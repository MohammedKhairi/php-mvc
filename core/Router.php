<?php
namespace app\core;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFondException;
use app\core\middlewares\ApiMiddleware;
use app\core\middlewares\AuthMiddleware;


class Router{
   public  Request $request;
   protected array $routes=[];
   protected array $AuthRoutes=[];
   protected array $ApiRoutes=[];
   protected array $SectionRoutes=[];

   public  Response $response;
   public  View $view;
   public function __construct(Request $request ,Response $response) {
    $this->request=$request;
    $this->response=$response;
   }
   public function isAutherize(){
        $arr=$this->request->getUrlArray();
        $path=$this->request->getUrl();
        #
        if(isset($arr[0]) && $arr[0]==cp("") )
            $this->AuthRoutes[]=$path;
        #
        if(isset($arr[0]) && $arr[0]==api("") )
            $this->ApiRoutes[]=$path;
        #
   }
   public function isSection($path,$is_section){
        if($is_section)
            $this->SectionRoutes[]=$path;
    }
   public function get($path , $callback,bool $is_section=false){
    $this->isAutherize();
    #
    $this->isSection($path,$is_section);
    #
    $this->routes['get'][$path]=$callback;
   }
   public function post($path , $callback,bool $is_section=false){
    $this->isAutherize();
    #
    $this->isSection($path,$is_section);
    #
    $this->routes['post'][$path]=$callback;
   }
   /**
    * Both Post and Get Request
    */
   public function req($path , $callback,bool $is_section=false){
    $this->isAutherize();
    #
    $this->isSection($path,$is_section);
    #
    if($this->request->isGet())
        $this->routes['get'][$path]=$callback;
    if($this->request->isPost())
        $this->routes['post'][$path]=$callback;
   }
   public function getCallback(){
    
     $method=$this->request->getMethod(); 
     $url=$this->request->getUrl(); 
     $url=trim($url,'/');
     //get All Routes from current request method
     $routes=$this->routes[$method]??[];

     $routeParams=false; 

     foreach ($routes as $route => $callback) {
        $route=trim($route,'/');
        $routeNames=[]; 
        if(!$route){
            continue;
        }
        //Find All Route Names From Route and save them $routeNames

        if(preg_match_all ('/\{(\w+)(:[^}]+)?}/',$route,$matches)){
            $routeNames=$matches[1];
        }

        //convert route name into regex pattren
        $routeRegex="@^".preg_replace_callback('/\{\w+(:([^}]+))?}/',fn($m)=>isset($m[2])?"({$m[2] })":'(\w+)',$route)."$@";

        //Match current Rout gainst $routeRegex
        if(preg_match_all($routeRegex,$url,$valuesMatches)){
            $values=[];
            for ($i=1; $i < count($valuesMatches); $i++) { 
                $values[]=$valuesMatches[$i][0]; 
            }
            
            $routeParams=array_combine($routeNames,$values);
            $this->request->setRouteParams($routeParams);
            return $callback; 
        }
         
     }
     #
     return false; 
     
   }
   public function resolve(){
    
    $path=$this->request->getUrl();
    #
    $method=$this->request->getMethod();
    #
    $callback=$this->routes[$method][$path]??false;
    #Note Fond
    if(false ===$callback){
        #
        $callback=$this->getCallback();
        if($callback===false){
             throw new NotFondException(); 
        }
        #
    }
    /**
     * --------CP Auth--------
     * check route with middleware
     * if path is not auth shoe no Permissions Page
     */
    if(in_array($path,$this->AuthRoutes)){
        $Authmiddileware=new AuthMiddleware();
        $_Auth=$Authmiddileware->execute();
        if(!$_Auth){
            throw new ForbiddenException();
        }
        ###################[if Not Super admin]##################
        //
        $lvl = Application::$app->session->get('user')['lvl']??'';
        if($lvl != 'admin'){
            $links=$this->request->getUrlArray();
            $program=$links[1]??'';
            $section='';
            if(in_array($path,$this->SectionRoutes)){
                $section=$links[2]??'';
            }
    
            $is_Permission=$Authmiddileware->isPermission(program:$program,section:$section,method:$callback[1]??'');
            if(!$is_Permission)
                throw new ForbiddenException();
        }
       
        //
    }
    /**
     * --------API Auth--------
     */
    if(in_array($path,$this->ApiRoutes)){
        $Apimiddileware=new ApiMiddleware();
        $_Auth=$Apimiddileware->execute();
        if(!$_Auth)
            throw new ForbiddenException();
    }
    #Only View 
    if(is_string($callback)){
         return  $this->view->renderView($callback);
    }
    #Controller with Method
    if(is_array($callback)){
        Application::$app->controller =new $callback[0]();
        $callback[0]=Application::$app->controller;
    }
    /**
     * Set the Layout and Perfixe link 
     */
    #Set CP
    if(in_array($path,$this->AuthRoutes)){
        Application::$app->controller->layout="admin";
        Application::$app->view->prev ='admin/';
    }

    #Set API
    if(in_array($path,$this->ApiRoutes)){
        Application::$app->controller->layout="api";

    }
    /**
     * Send the script 
     */
    return call_user_func($callback,$this->request,$this->response );
   }
} 