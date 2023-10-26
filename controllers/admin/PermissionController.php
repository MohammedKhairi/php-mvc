<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Permission;

class PermissionController extends Controller{   
    public function get(Request $request) {
        
        $PermissionModel=new Permission();
        return $this->reander('permissions',[
                'title'=>'Permission Page',
                'data'=>$PermissionModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $PermissionModel=new Permission();
        if($request->isPost())
        {
            $PermissionModel->loadData($request->getBody());

            if($PermissionModel->validate() && $PermissionModel->insert() ){
                Application::$app->session->setFlash('success','Permission Add Successfuly');
                Application::$app->response->redirect('/cp/permission');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }

        return $this->reander('permissions-set',[
                'model'=>$PermissionModel,
                'name'=>'add',
                'title'=>'Add New Permission',
            ]
        );
    }
    public function edit(Request $request) {
         
        $PermissionModel=new Permission();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $PermissionModel->loadData($request->getBody());

            if($PermissionModel->validate() && $PermissionModel->update($id) )
            {
                Application::$app->session->setFlash('success','Permission Update Successfuly');
                Application::$app->response->redirect('/cp/permission');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        #get Data
    
        if($id){
            $data=$PermissionModel->getOne($id);
            $PermissionModel->user_id=$data['user_id'];
            $PermissionModel->group_id=$data['group_id'];
            $PermissionModel->program_id=$data['program_id'];
        }
        return $this->reander('permissions-set',[
                'model'=>$PermissionModel,
                'name'=>'update',
                'title'=>'Edit Permission: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $PermissionModel=new Permission();
        if($request->isGet())
        {
            $PermissionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $PermissionModel->remove($id) ){
                Application::$app->session->setFlash('success','Permission Deleted Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/permission');
        exit;
    }
    public function restore(Request $request) {
        
        $PermissionModel=new Permission();
        if($request->isGet())
        {
            $PermissionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $PermissionModel->restore($id) ){
                Application::$app->session->setFlash('success','Permission Deleted Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/permission');
        exit;
    }
    
}