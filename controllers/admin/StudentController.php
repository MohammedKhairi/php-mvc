<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Division;
use app\models\Grade;
use app\models\Student;

class StudentController extends Controller{ 
    public function get(Request $request) {
        
        $StudentModel=new Student();
        return $this->reander('student',[
                'title'=>'صفحة الطلاب',
                'data'=>$StudentModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $StudentModel=new Student();
        if($request->isPost())
        {
            $StudentModel->loadData($request->getBody());
            if($StudentModel->validate(['division_id']) && $StudentModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/student');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $StudentModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $StudentModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');

        return $this->reander('student-set',[
                'model'=>$StudentModel,
                'name'=>'add',
                'title'=>'اضافة طالب جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $StudentModel=new Student();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $StudentModel->loadData($request->getBody());
            if($StudentModel->validate(['img','division_id']) && $StudentModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/student');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$StudentModel->getOneById($id);
            $StudentModel->user_id=$data['user_id'];
            $StudentModel->name=$data['name'];
            $StudentModel->last_name=$data['last_name'];
            $StudentModel->gander=$data['gander'];
            $StudentModel->phone=$data['phone'];
            $StudentModel->grade_id=$data['grade_id'];
            $StudentModel->division_id=$data['division_id'];
            $StudentModel->birthday=Application::$app->fun->getUTS($data['birthday']);
            $StudentModel->join_date=Application::$app->fun->getUTS($data['join_date']);
            $StudentModel->installment=$data['installment'];
            $StudentModel->discount=$data['discount'];
            $StudentModel->img=$data['img'];
            $StudentModel->address=$data['address'];
        }
        $GradeModel=new Grade();
        $DivisionModel=new Division();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();

        $StudentModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $StudentModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');

        return $this->reander('student-set',[
                'model'=>$StudentModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الطالب: '.$data['name']??'',
            ]
        );
    }
    public function delete(Request $request) {
        
        $StudentModel=new Student();
        if($request->isGet())
        {
            $StudentModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $StudentModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/student');
        exit; 


    }
    public function restore(Request $request) {
        
        $StudentModel=new Student();
        if($request->isGet())
        {
            $StudentModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $StudentModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/student');
        exit; 


    }
}