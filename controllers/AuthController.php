<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller {

    public function login(Request $request){
        $this->setLayout('auth');
        return $this->reander('login');
    }
    public function register(Request $request){
        $userModel=new User();
        if($request->isPost())
        {
            $userModel->loadData($request->getBody());

            if($userModel->validate() && $userModel->register()){
                 Application::$app->session->setFlash('success','Thank You For Register');
                 Application::$app->response->redirect('/');
                 exit; 
            }
        }
        $this->setLayout('auth');
        
        return $this->reander('register',['model'=>$userModel]);
    }
}