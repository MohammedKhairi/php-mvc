<?php
namespace app\core;


class Router{
   public  Request $request;
   protected array $routes=[];
   public  Response $response;
 
   
   public function __construct(Request $request ,Response $response) {
    $this->request=$request;
    $this->response=$response;
   }
   public function get($path , $callback){
     
    $this->routes['get'][$path]=$callback;
   }
   public function post($path , $callback){
     
    $this->routes['post'][$path]=$callback;
   }

   public function resolve(){

    $path=$this->request->getPath();

    $method=$this->request->method();
    
    $callback=$this->routes[$method][$path]??false;
    
    #Note Fond
    if(false ===$callback){
        $this->response->setStatusCode(404);
        return $this->renderView("_404");
    }
    #Only View 
    if(is_string($callback)){
         return  $this->renderView($callback);
    }
    #Controller with Method
    if(is_array ($callback)){
        Application::$app->controller =new $callback[0]();
        $callback[0]=Application::$app->controller;

    }
    return call_user_func($callback,$this->request);

   }

   public function renderView($view,$params=[] ){
    $layoutcontent=$this->layoutContent();
    $viewContent=$this->reanderOnlyView($view,$params);
    return str_replace('{content}',$viewContent,$layoutcontent);
   }

   public function layoutContent(){
     $layout=Application::$app->controller->layout;
    //$layout='main';
    ob_start();
    include_once Application::$ROOT_DIR.'/views/layout/'.$layout.'.php';
    return ob_get_clean(); 
   }
   protected function reanderOnlyView($view,$params=[]){
    /**
     * SET Value To Var 
     * And Sent them to View Page
     */
    foreach ($params as $key => $value) {
        $$key= $value; 
    }

    ob_start();
    include_once Application::$ROOT_DIR.'/views/'.$view.'.php';
    return ob_get_clean(); 
   }
}