<?php 
namespace app\core\middlewares;
use app\core\Application;

class AuthMiddleware {
    public function execute():bool{
        if(empty(Application::$app->isAuth())){
            return true;
        }
        return false;
    }

}