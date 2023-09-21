<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Admin;

class UserController extends Controller{   
    public function __construct() {
        $this->setLayout('admin');
        $this->setPrevPage('/admin');
    }
    public function get(Request $request) {
        
        $UserModel=new Admin();

        return $this->reander('users',[
                'title'=>'User Page',
                'data'=>$UserModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $UserModel=new Admin();
        if($request->isPost())
        {
            $UserModel->loadData($request->getBody());

            if($UserModel->validate() && $UserModel->insert() ){
                Application::$app->session->setFlash('success','User Add Successfuly');
                Application::$app->response->redirect('/cp/user');
                exit; 
            }
            else
                Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }

        return $this->reander('user-set',[
                'model'=>$UserModel,
                'name'=>'add',
                'title'=>'Add New User',
            ]
        );
    }
    public function edit(Request $request) {
         
        $UserModel=new Admin();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $UserModel->loadData($request->getBody());

            if(
                $UserModel->validate(['password','img','email']) && 
                $UserModel->update($id) 
            )
            {
                Application::$app->session->setFlash('success','User Update Successfuly');
                Application::$app->response->redirect('/cp/user');
                exit; 
            }
             else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        #get Data
    
        if($id){
            $data=$UserModel->getOne($id);
            $UserModel->username=$data['username'];
            $UserModel->email=$data['email'];
            //$UserModel->password=$data['password'];
            $UserModel->img=$data['img'];
            $UserModel->lvl=$data['lvl'];
        }
        return $this->reander('user-set',[
                'model'=>$UserModel,
                'name'=>'update',
                'title'=>'Edit User: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $UserModel=new Admin();
        if($request->isGet())
        {
            $UserModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $UserModel->remove($id) ){
                Application::$app->session->setFlash('success','User Deleted Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/user');
        exit; 


    }
    public function restore(Request $request) {
        
        $UserModel=new Admin();
        if($request->isGet())
        {
            $UserModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $UserModel->restore($id) ){
                Application::$app->session->setFlash('success','User Restore Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/user');
        exit; 


    }
}