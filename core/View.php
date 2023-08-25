<?php
namespace app\core;

class View
{

    public string $title = '';

    public function renderView($view, $params = [])
    {
        $this->title=$params['title']??'';
        $layoutcontent = $this->layoutContent();

        $viewContent = $this->reanderOnlyView($view, $params);

        return str_replace('{content}', $viewContent, $layoutcontent);
    }
    public function layoutContent()
    {

        $layout = Application::$app->layout;

        if (isset(Application::$app->controller) && Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        //$layout='main';
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
        include_once Application::$ROOT_DIR . '/views/' . $view . '.php';
        return ob_get_clean();
    }
}