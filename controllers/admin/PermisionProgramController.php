<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\PermisionProgram;

class PermisionProgramController extends Controller{   
    public function get(Request $request) {
        $programModel=new PermisionProgram();
        return $this->reander('permission-programes',[
                'title'=>'صفحة البرامج',
                'data'=>$programModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $programModel=new PermisionProgram();
        if($request->isPost())
        {
            $programModel->loadData($request->getBody());

            if($programModel->validate() && $programModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/permission/program');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }

        return $this->reander('permission-programes-set',[
                'model'=>$programModel,
                'name'=>'add',
                'title'=>'اضافة برنامج جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $programModel=new PermisionProgram();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $programModel->loadData($request->getBody());

            if(
               // $programModel->validate() && 
                $programModel->update($id) )
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/permission/program');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$programModel->getOne($id);
            $programModel->name=$data['name'];
            $programModel->title=$data['title'];
        }
        return $this->reander('permission-programes-set',[
                'model'=>$programModel,
                'name'=>'update',
                'title'=>'تعديل بيانات البرنامج: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $programModel=new PermisionProgram();
        if($request->isGet())
        {
            $programModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $programModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/permission/program');
        exit; 


    }
    public function restore(Request $request) {
        
        $programModel=new PermisionProgram();
        if($request->isGet())
        {
            $programModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $programModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/permission/program');
        exit; 


    }
}