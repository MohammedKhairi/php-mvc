<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Login;
use app\models\Register;

class AuthController extends Controller {
    public function login(Request $request){

        $loginModel=new Login();
        if($request->isPost())
        {
            $loginModel->loadData($request->getBody());

            if($loginModel->validate() && $loginModel->login()){
                 Application::$app->session->setFlash('success','Thank You For Login');
                 Application::$app->response->redirect('/');
                 exit; 
            }
        }

        $this->setLayout('auth');
        return $this->reander('login',['model'=>$loginModel]);
    }
    public function logout(){
        $response=new Response(); 
        Application::$app->session->remove('user');
        $response->redirect('/');
    }
    public function profile(){
        $loginModel=new Login();
        return $this->reander('profile',[
            'model'=>$loginModel,
            'title'=>'Profile Page'
        ]);
    }
}