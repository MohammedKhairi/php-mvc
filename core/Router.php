<?php
namespace app\core;

use app\core\exception\ForbiddenException;
use app\core\exception\NotFondException;
use app\core\middlewares\ApiMiddleware;
use app\core\middlewares\AuthMiddleware;


class Router
{
    public Request $request;
    protected array $routes = [];
    protected array $AuthRoutes = [];
    protected array $ApiRoutes = [];
    protected array $ActionsRoutes = [];

    public Response $response;
    public View $view;
    public string $currentPath='';
    public string $_path='';
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->currentPath = $request->getUrl();
    }
    public function AutherizeRout($path,$_action)
    {
        $arr = $this->request->getUrlArray();
        // vd($arr);
        #
        if (isset($arr[0]) && $arr[0] == cp(""))
            $this->AuthRoutes[] = $path;
        #
        if (isset($arr[0]) && $arr[0] == api(""))
            $this->ApiRoutes[] = $path;
        #
        $this->setActions($path,$_action);
        #
    }
    public function setActions($path,$_action)
    {
        if (!empty($_action))
            $this->ActionsRoutes[$path] = $_action;
    }
    /**
     * Both Post and Get Request
     */
    public function req($path, $callback, string $_action = '')
    {
        // vd("O_Path:".$path);
        // vd("N_Path:".$path);

        $this->AutherizeRout($path,$_action);
        #
        if ($this->request->isGet())
            $this->routes['get'][$path] = $callback;
        if ($this->request->isPost())
            $this->routes['post'][$path] = $callback;
    }
    public function getCallback()
    {

        $method = $this->request->getMethod();
        $url = $this->currentPath;
        $url = trim($url, '/');
        //get All Routes from current request method
        $routes = $this->routes[$method] ?? [];

        $routeParams = false;

        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');
            $routeNames = [];
            if (!$route) {
                continue;
            }

            //Find All Route Names From Route and save them $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            //convert route name into regex pattren
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            //Match current Rout gainst $routeRegex
            if (preg_match_all($routeRegex, $url, $valuesMatches)) {
                $values = [];
                for ($i = 1; $i < count($valuesMatches); $i++) {
                    $values[] = $valuesMatches[$i][0];
                }

                $routeParams = array_combine($routeNames, $values);
                $this->request->setRouteParams($routeParams);
                $this->_path="/".$route;
                return $callback;
            }

        }
        #
        return false;

    }
    public function resolve()
    {
        
        //exit;
        $this->_path=$this->currentPath;
        #
        $method = $this->request->getMethod();
        #
        $callback = $this->routes[$method][$this->_path] ?? false;

        #Note Fond
        if (false === $callback) {
            #
            $callback = $this->getCallback();
            if ($callback === false) {
                throw new NotFondException();
           }
            #
        }
        /**
         * --------CP Auth--------
         * check route with middleware
         * if path is not auth show no Permissions Page
         */
        #
        if (in_array($this->_path, $this->AuthRoutes)) {
            $Authmiddileware = new AuthMiddleware();
            $_Auth = $Authmiddileware->execute();
            if (!$_Auth) {
                throw new ForbiddenException();
            }
            ###################[if Not Super admin]##################
            $lvl = Application::$app->session->get('user')['lvl'];

            if ($lvl != 'admin') {
                //check if the user have the pemisson for this link
                if (isset($this->ActionsRoutes[$this->_path])) {
                    $links = explode('.', $this->ActionsRoutes[$this->_path]);
                    $program = $links[0] ?? '';
                    $method = $links[1] ?? '';

                    $is_Permission = $Authmiddileware->isPermission(lvl: $lvl, program: $program, method: $method);
                    if (!$is_Permission)
                        throw new ForbiddenException();
                }

            }
        }
        /**
         * --------API Auth--------
         */
        if (in_array($this->_path, $this->ApiRoutes)) {
            $Apimiddileware = new ApiMiddleware();
            $_Auth = $Apimiddileware->execute();
            if (!$_Auth)
                throw new ForbiddenException();
        }
        #Only View 
        if (is_string($callback)) {
            return $this->view->renderView($callback);
        }
        #Controller with Method
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        /**
         * Set the Layout and Perfixe link 
         */
        #Set CP
        if (in_array($this->_path, $this->AuthRoutes)) {
            Application::$app->controller->layout = "admin";
            Application::$app->view->prev = 'admin/';
        }
        #Set API
        if (in_array($this->_path, $this->ApiRoutes)) {
            Application::$app->controller->layout = "api";
        }
        /**
         * Send the script 
         */
        return call_user_func($callback, $this->request, $this->response);
    }
}