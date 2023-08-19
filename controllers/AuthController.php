<?php 
namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller {

    public function login(Request $request){
        $this->setLayout('auth');
        return $this->reander('login');
    }
    public function register(Request $request){
        /**
         * Start Post Operation
         */
        $registerModel=new RegisterModel();
        if($request->isPost())
        {
            $registerModel->loadData($request->getBody());

            if($registerModel->validate() && $registerModel->register()){
                return "Success";
            }
             

        }
        $this->setLayout('auth');
        
        return $this->reander('register',['model'=>$registerModel]);
    }
}