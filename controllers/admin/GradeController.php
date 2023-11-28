<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Grade;


class GradeController extends Controller{ 
    public function get(Request $request) {
        
        $GradeModel=new Grade();
        return $this->reander('grades',[
                'title'=>'صفحة الصفوف',
                'data'=>$GradeModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $GradeModel=new Grade();
        if($request->isPost())
        {
            $GradeModel->loadData($request->getBody());
            if($GradeModel->validate() && $GradeModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/grade');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        return $this->reander('grade-set',
            [
                'model'=>$GradeModel,
                'name'=>'add',
                'title'=>'اضافة صفوف جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $GradeModel=new Grade();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $GradeModel->loadData($request->getBody());

            if($GradeModel->validate() && $GradeModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/grade');
                exit; 
            }
             else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$GradeModel->getOne($id);
            $GradeModel->name=$data['name'];
            $GradeModel->less_age=$data['less_age'];
            $GradeModel->oldest_age=$data['oldest_age'];
        }
        return $this->reander('grade-set',[
                'model'=>$GradeModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الصف: '.$data['name']??'',
            ]
        );
    }
    public function delete(Request $request) {
        
        $GradeModel=new Grade();
        if($request->isGet())
        {
            $GradeModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $GradeModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/grade');
        exit; 


    }
    public function restore(Request $request) {
        
        $GradeModel=new Grade();
        if($request->isGet())
        {
            $GradeModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $GradeModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/grade');
        exit; 


    }
}