<?php  
 namespace app\core;

 class Controller{
    public string $layout='main';

    public function setLayout($layout=''){
        
        $this->layout=$layout;
    }
    public function reander($view,$params=[]) {
        
        return Application::$app->view->renderView($view,$params); 
    }
    
 } 