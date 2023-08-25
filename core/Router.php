<?php
namespace app\core;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFondException;
use app\core\middlewares\AuthMiddleware;


class Router{
   public  Request $request;
   protected array $routes=[];
   protected array $AuthRoutes=[];
   public  Response $response;
   public  View $view;
  
 
   
   public function __construct(Request $request ,Response $response) {
    $this->request=$request;
    $this->response=$response;
   }
   public function isAutherize($path){
        $this->AuthRoutes[]=$path;
   }
   public function get($path , $callback,$isAuth=false){
    if($isAuth)
        $this->isAutherize($path);
    #
    $this->routes['get'][$path]=$callback;
   }
   public function post($path , $callback,$isAuth=false){
    if($isAuth)
        $this->isAutherize($path);
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
     * check route with middleware
     * if path is not auth shoe no Permissions Page
     */
    if(in_array($path,$this->AuthRoutes)){
        $middileware=new AuthMiddleware();
        $_Auth=$middileware->execute();
        if($_Auth){
            throw new ForbiddenException();
        }
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
    return call_user_func($callback,$this->request,$this->response );
   }

} 