<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Division;
use app\models\Grade;
use app\models\Alert;
use app\models\AlertDivision;
use app\models\Comment;


class AlertController extends Controller{ 
    public function get(Request $request) {
        
        $AlertModel=new Alert();
        return $this->reander('alert',[
                'title'=>'صفحة التبليغات',
                'data'=>$AlertModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $AlertModel=new Alert();
        if($request->isPost())
        {
            $AlertModel->loadData($request->getBody());
            if($AlertModel->validate(['filename','division_id']) && $AlertModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/alert');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $AlertModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $AlertModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');

        return $this->reander('alert-set',[
                'model'=>$AlertModel,
                'name'=>'add',
                'title'=>'اضافة تبليغ جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $AlertModel=new Alert();
        $AlertDivisionModel=new AlertDivision();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $AlertModel->loadData($request->getBody());
            if($AlertModel->validate(['filename','division_id']) && $AlertModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/alert');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$AlertModel->getOne($id);
            if(empty($data)){
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));
                Application::$app->response->redirect('/cp/alert');
                exit; 
            }
            $AlertModel->emp_id=$data['emp_id'];
            $AlertModel->grade_id=$data['grade_id'];
            $AlertModel->division_id=Application::$app->fun->OrderdArray($AlertDivisionModel->getAllByAlert($data['id']),'id','dname');
            $AlertModel->content=$data['content'];
            $AlertModel->filename=$data['filename'];
        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $AlertModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $AlertModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');

        return $this->reander('alert-set',[
                'model'=>$AlertModel,
                'name'=>'update',
                'title'=>'تعديل بيانات التبليغ',
            ]
        );
    }
    public function show(Request $request) {
        
        $AlertModel=new Alert();
        $CommentModel=new Comment();
        $DivisionModel=new AlertDivision();
        $id=$request->getRouteParams()['id']??0;
        /**
         * Insert Comment
         */
        $comment=$request->getBody()['comment']??'';
        if(!empty($comment))
        {
            if($CommentModel->insert($id , "alert" ,$comment) )
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        return $this->reander('alert-show',[
                'title'=>'صفحة التبليغ',
                'fname'=>'add_comment',
                'model'=>$CommentModel,
                'data'=>[
                    "info"=>$AlertModel->getOneInfo($id),
                    "division"=>$DivisionModel->getAllByAlert($id),
                    "comments"=>$CommentModel->getByType("alert",$id),
                ],
            ]
        );
    }
    public function delete(Request $request) {
        
        $AlertModel=new Alert();
        if($request->isGet())
        {
            $AlertModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $AlertModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/alert');
        exit; 


    }
    public function restore(Request $request) {
        
        $AlertModel=new Alert();
        if($request->isGet())
        {
            $AlertModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $AlertModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/alert');
        exit; 


    }
}