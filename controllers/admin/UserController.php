<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Admin;

class UserController extends Controller{ 
    public function get(Request $request) {
        
        $UserModel=new Admin();

        return $this->reander('users',[
                'title'=>'صفحة الموظفين',
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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/user');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }

        return $this->reander('user-set',[
                'model'=>$UserModel,
                'name'=>'add',
                'title'=>'اضافة موظف جديد',
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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/user');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$UserModel->getOne($id);
            $UserModel->code=$data['code'];
            $UserModel->img=$data['img'];
            $UserModel->lvl=$data['lvl'];
        }
        return $this->reander('user-set',[
                'model'=>$UserModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الموظف: '.$data['username']??'',
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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/user');
        exit; 


    }
    public function profile(Request $request) {
         
        $UserModel=new Admin();
        $data=[];

        #Save Change
        if($request->isPost())
        {
            $UserModel->loadData($request->getBody());
            if(
                $UserModel->profile(Application::$app->session->get('user')['id'])
            )
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/user/profile');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
        $data=$UserModel->getOne(Application::$app->session->get('user')['id']);
        $UserModel->code=$data['code'];
        $UserModel->img=$data['img'];
        return $this->reander('user-profile',[
                'model'=>$UserModel,
                'name'=>'profiel',
                'title'=>'الملف الشخصي: '.$data['username']??'',
            ]
        );
    }
}