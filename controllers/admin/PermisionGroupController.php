<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\PermisionGroup;
use app\models\PermisionGroupAction;
use app\models\PermisionGroupProgram;
use app\models\PermisionProgram;

class PermisionGroupController extends Controller{  
    public $actionOption=[]; 
    public function get() {
        $groupModel=new PermisionGroup();
        return $this->reander('permission-groups',[
                'title'=>'صفحة المجموعات',
                'data'=>$groupModel->getGroups(),
            ]
        );
    }
    public function add(Request $request) {
        
        $groupModel=new PermisionGroup();
        if($request->isPost())
        {
            
            $groupModel->loadData($request->getBody());

            if($groupModel->validate() && $groupModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/permission/group');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        $ProgramModel=new PermisionProgram();

        $programs=$ProgramModel->get();
        $groupModel->programOption=Application::$app->fun->OrderdArray($programs,'id','title');
        //
        return $this->reander('permission-groups-set',[
                'model'=>$groupModel,
                'name'=>'add',
                'title'=>'اضافة مجموعة جديدة',
            ]
        );
    }
    public function edit(Request $request) {
         
        $groupModel=new PermisionGroup();
        $groupActionModel=new PermisionGroupAction();
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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/permission/group');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$groupModel->getOne($id);
            $gaction=$groupActionModel->get($id);
            $groupModel->title=$data['title'];
            $groupModel->name=$data['name'];
            $groupModel->program_id=$data['program_id'];
            $groupModel->action_id=Application::$app->fun->ArrayByKey($gaction,'aid');
             //
            $ProgramModel=new PermisionProgram();
            $programs=$ProgramModel->get();
            $groupModel->programOption=Application::$app->fun->OrderdArray($programs,'id','title');
            //
        }
        return $this->reander('permission-groups-set',[
                'model'=>$groupModel,
                'name'=>'update',
                'title'=>'تعديل بيانات المجموعة: '.$data['title']??'',
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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

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
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/permission/group');
        exit; 


    }
}