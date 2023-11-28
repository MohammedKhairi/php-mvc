<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\PermisionAction;

class PermisionActionController extends Controller{   
    public function get() {
        $actionModel=new PermisionAction();
        return $this->reander('permission-actions',[
                'title'=>'صفحة العمليات',
                'data'=>$actionModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $actionModel=new PermisionAction();
        if($request->isPost())
        {
            $actionModel->loadData($request->getBody());

            if($actionModel->validate() && $actionModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/permission/action');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }

        return $this->reander('permission-actions-set',[
                'model'=>$actionModel,
                'name'=>'add',
                'title'=>'اضافة عملية جديدة',
            ]
        );
    }
    public function edit(Request $request) {
         
        $actionModel=new PermisionAction();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $actionModel->loadData($request->getBody());

            if(
               // $actionModel->validate() && 
                $actionModel->update($id) )
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/permission/action');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$actionModel->getOne($id);
            $actionModel->name=$data['name'];
            $actionModel->title=$data['title'];
        }
        return $this->reander('permission-actions-set',[
                'model'=>$actionModel,
                'name'=>'update',
                'title'=>'تعديل بيانات العملية: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $actionModel=new PermisionAction();
        if($request->isGet())
        {
            $actionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $actionModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/permission/action');
        exit; 


    }
    public function restore(Request $request) {
        
        $actionModel=new PermisionAction();
        if($request->isGet())
        {
            $actionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $actionModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/permission/action');
        exit; 


    }
}