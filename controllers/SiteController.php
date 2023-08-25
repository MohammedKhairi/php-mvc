<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Contact;
use app\models\Department;

class SiteController extends Controller{

    public function home() {
        $param=[
            'name'=>"Mohammed",
        ];
        return $this->reander('home',$param);
    }    
    public function contact(Request $request) {
        
        print_r($request->getRouteParams());
        
        $departmentsModel=new Department();
        $deps=$departmentsModel->get();
        $departments=[];
        foreach ($deps as $dep) {
            $departments[$dep['id']]=$dep['title'];
        }
        $contactModel=new Contact();
        if($request->isPost())
        {
            $contactModel->loadData($request->getBody());

            if($contactModel->validate() && $contactModel->insert()){
                 Application::$app->session->setFlash('success','Message Send Success');
                 Application::$app->response->redirect('/');
                 exit; 
            }
        }

        return $this->reander('contact',[
                'model'=>$contactModel,
                'departments'=>$departments,
            ]
        );
    }
     
}