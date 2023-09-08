<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\PermisionGroup;

class PermisionGroupController extends Controller{  
    public $actionOption=[]; 
    public function __construct() {
        $this->setLayout('admin');
        $this->setPrevPage('/admin');
    }
    public function get() {
        $groupModel=new PermisionGroup();
        return $this->reander('permission-groups',[
                'title'=>'Permission Group Page',
                'data'=>$groupModel->getGroupAction(),
            ]
        );
    }
    public function add(Request $request) {
        
        $groupModel=new PermisionGroup();
        if($request->isPost())
        {
            
            $groupModel->loadData($request->getBody());

            if($groupModel->validate() && $groupModel->insert() ){
                Application::$app->session->setFlash('success','Permission Group Add Successfuly');
                Application::$app->response->redirect('/cp/permission/group');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }

        return $this->reander('permission-groups-set',[
                'model'=>$groupModel,
                'name'=>'add',
                'title'=>'Add New Permission Group',
            ]
        );
    }
    public function edit(Request $request) {
         
        $groupModel=new PermisionGroup();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $groupModel->loadData($request->getBody());

            if(
               // $groupModel->validate() && 
                $groupModel->update($id) )
            {
                Application::$app->session->setFlash('success','Permission Group Update Successfuly');
                Application::$app->response->redirect('/cp/permission/group');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        #get Data
    
        if($id){
            $data=$groupModel->getOne($id);
            $groupModel->name=$data['name'];
        }
        return $this->reander('permission-groups-set',[
                'model'=>$groupModel,
                'name'=>'update',
                'title'=>'Edit Permission Group: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $groupModel=new PermisionGroup();
        if($request->isGet())
        { 
            $groupModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $groupModel->remove($id) ){
                Application::$app->session->setFlash('success','Permission Group Deleted Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/permission/group');
        exit; 


    }
    public function restore(Request $request) {
        
        $groupModel=new PermisionGroup();
        if($request->isGet())
        {
            $groupModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $groupModel->restore($id) ){
                Application::$app->session->setFlash('success','Permission Group Restore Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/permission/group');
        exit; 


    }
}