<?php  
 namespace app\core;

 class Controller{ 
    public string $layout='main';

    public function setLayout($layout=''){
        $this->layout=$layout;
    }
    public function setPrevPage($prev){
        Application::$app->view->prev=$prev;
    }
    public function setTitle($title=''){
        Application::$app->view->title=$title;
    }
    public function reander($view,$params=[]) {
        return Application::$app->view->renderView($view,$params); 
    }
    public function reanderApi($params=[]) {
        return Application::$app->view->renderApiView($params); 
    }
    
 } 