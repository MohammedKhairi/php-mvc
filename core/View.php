<?php
namespace app\core;

class View
{

    public string $app_title = '';
    public string $prev = '';
    public function __construct($link='') {
        $this->prev = $link;
    }
    public function setPrivLink($link){
        $this->prev=$link;
    }
    public function renderView($view, $params = [])
    {
        $this->app_title=$params['app_title']??'';
        $layoutcontent = $this->layoutContent();

        $viewContent = $this->reanderOnlyView($view, $params);

        return str_replace('{content}', $viewContent, $layoutcontent);
    }
    public function renderApiView($params = [])
    {
        $layoutcontent = $this->layoutContent();
        return str_replace('{content}',json_encode($params) , $layoutcontent);
    }
    public function layoutContent()
    {

        $layout = Application::$app->layout;

        if (isset(Application::$app->controller) && Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        $app_title=$this->app_title;
        ob_start();
        include_once Application::$ROOT_DIR . '/views/layout/' . $layout . '.php';
        return ob_get_clean();
    }
    protected function reanderOnlyView($view, $params = [])
    {
        /**
         * SET Value To Var 
         * And Sent them to View Page
         */
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . '/views/' . $this->prev .$view . '.php';
        return ob_get_clean();
    }
}