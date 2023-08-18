<?php

namespace app\core;
use app\core\Request;
use app\core\Router;
use app\core\Response;
class Application {
    public  Router $router;
    public  Request $request;
    public  Controller $controller;
    public  Response $response;
    public static Application $app;
    public static string $ROOT_DIR; 
    public function __construct($rootPath) {
        self::$ROOT_DIR=$rootPath; 
        self::$app=$this ; 
        $this->request=new Request();
        $this->response=new Response();
        $this->router=new Router($this->request,$this->response);
    }
    public function run() {
        echo $this->router->resolve();
    }
     
}