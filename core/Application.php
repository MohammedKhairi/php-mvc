<?php

namespace app\core;
use app\core\Request;
use app\core\Router;
use app\core\Response;
use app\core\Database;
class Application {
    public  Router $router;
    public  Request $request;
    public  Controller $controller;
    public  Response $response;
    public  Session $session;
    public  View $view;
    public  Database $db ;
    public static Application $app;
    public static string $ROOT_DIR; 
    public string $layout='main';
    public function __construct($rootPath,$config=array()) {
        self::$ROOT_DIR=$rootPath; 
        self::$app=$this ; 
        $this->request=new Request();
        $this->response=new Response();
        $this->session=new Session ();
        $this->view=new View();
        $this->db=new Database($config['db']);
        $this->router=new Router($this->request,$this->response);
    }
    public function run() {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            //print_r($e);exit;
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error',['exceptions'=>$e]); 
        }
    }
    public function isAuth(){
       return $this->session->get('user');
    }

   
}