<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Division;
use app\models\Grade;
use app\models\Task;
use app\models\TaskSolve;
use app\models\Dars;
use app\models\TaskDivision;
use app\models\Message;

class TaskController extends Controller{ 
    public function get(Request $request) {
        
        $TaskModel=new Task();
        return $this->reander('task',[
                'title'=>'صفحة المهمات',
                'data'=>$TaskModel->get(),
            ]
        );
    }
    public function show(Request $request) {
        
        $TaskModel=new Task();
        $MessageModel=new Message();
        $DivisionModel=new TaskDivision();
        $id=$request->getRouteParams()['id']??0;
        /**
         * Insert Comment
         */
        $message=$request->getBody()['message']??'';
        if(!empty($message))
        {
            if($MessageModel->insert($id , "task" ,$message) )
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        return $this->reander('task-show',[
                'title'=>'صفحة المهمة',
                'fname'=>'add_comment',
                'model'=>$MessageModel,
                'data'=>[
                    "info"=>$TaskModel->getOneInfo($id),
                    "division"=>$DivisionModel->getAllByTask($id),
                    "comments"=>$MessageModel->getByType("task",$id),
                ],
            ]
        );
    }
    public function solve(Request $request) {
        
        $TaskModel=new Task();
        $TaskSolveModel=new TaskSolve();
        $DivisionModel=new TaskDivision();
        $id=$request->getRouteParams()['id']??0;
        //
        if($request->isPost())
        {
            $TaskSolveModel->loadData($request->getBody());
            if($TaskSolveModel->validate(['filename','content']) && $TaskSolveModel->insert() )
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));
        }
        //
        return $this->reander('task-solve',[
                'title'=>'صفحة حل المهمة',
                'fname'=>'solve',
                'model'=>$TaskSolveModel,
                'data'=>[
                    "info"=>$TaskModel->getOneInfo($id),
                    "solve"=>$TaskSolveModel->getAllByTask($id),
                    "division"=>$DivisionModel->getAllByTask($id),
                ],
            ]
        );
    }
    public function add(Request $request) {
        
        $TaskModel=new Task();
        if($request->isPost())
        {
            $TaskModel->loadData($request->getBody());
            if($TaskModel->validate(['filename','division_id']) && $TaskModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/task');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $TaskModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $TaskModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');
        //
        $DarsModel=new Dars();
        $dars=[];
        foreach($DarsModel->getAllWithDit() as $d)
            $dars[$d['id']]=$d['mname'].' - '.$d['gname'].' - '.(!empty($d['dname'])?$d['dname'].' - ':'').$d['tname'];       
        
        $TaskModel->darsOption=$dars;
        //
        return $this->reander('task-set',[
                'model'=>$TaskModel,
                'name'=>'add',
                'title'=>'اضافة مهمة جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $TaskModel=new Task();
        $TaskDivisionModel=new TaskDivision();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $TaskModel->loadData($request->getBody());
            if($TaskModel->validate(['filename','division_id']) && $TaskModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/task');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$TaskModel->getOne($id);
            if(empty($data)){
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));
                Application::$app->response->redirect('/cp/task');
                exit; 
            }
            $TaskModel->emp_id=$data['emp_id'];
            $TaskModel->dars_id=$data['dars_id'];
            $TaskModel->grade_id=$data['grade_id'];
            $TaskModel->division_id=Application::$app->fun->OrderdArray($TaskDivisionModel->getAllByTask($data['id']),'id','dname');
            $TaskModel->task=$data['task'];
            $TaskModel->deliver_date=Application::$app->fun->getUTS($data['deliver_date']);
            $TaskModel->is_comment=$data['is_comment'];

        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $TaskModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $TaskModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');
        //
        $DarsModel=new Dars();
        $dars=[];
        foreach($DarsModel->getAllWithDit() as $d)
            $dars[$d['id']]=$d['mname'].' - '.$d['gname'].' - '.(!empty($d['dname'])?$d['dname'].' - ':'').$d['tname'];       
        
        $TaskModel->darsOption=$dars;
        //
        return $this->reander('task-set',[
                'model'=>$TaskModel,
                'name'=>'update',
                'title'=>'تعديل بيانات المهمة',
            ]
        );
    }
    public function delete(Request $request) {
        
        $TaskModel=new Task();
        if($request->isGet())
        {
            $TaskModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $TaskModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/task');
        exit; 


    }
    public function restore(Request $request) {
        
        $TaskModel=new Task();
        if($request->isGet())
        {
            $TaskModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $TaskModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/task');
        exit; 


    }
}