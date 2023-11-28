<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Dars;
use app\models\Exam;


class ExamController extends Controller{ 
    public $examType='';

    public function get(Request $request) {
        $this->examType = $request->getRouteParams()['exam']??'';
        $ExamModel=new Exam();
        $ExamModel->type=$this->examType;
        return $this->reander('exam',[
                'title'=>'صفحة جدول الامتحانات '.Application::$app->fun->getTableLearning($this->examType),
                'examType'=>$this->examType,
                'data'=>$ExamModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        $this->examType = $request->getRouteParams()['exam']??'';
        $ExamModel=new Exam();
        $ExamModel->type=$this->examType;
        $ExamModel->lessonsOption=Application::$app->fun->ArrayByValue($ExamModel->lessonsOption);
        $ExamModel->daysOption=Application::$app->fun->ArrayByValue($ExamModel->daysOption);
        if($request->isPost())
        {
            $ExamModel->loadData($request->getBody());
            if($ExamModel->validate() && $ExamModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/learning/'.$this->examType);
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        $DarsModel=new Dars();
        $dars=[];
        foreach($DarsModel->getAllWithDit() as $d)
            $dars[$d['id']]=$d['mname'].' - '.$d['gname'].' - '.(!empty($d['dname'])?$d['dname'].' - ':'').$d['tname'];       
        
        $ExamModel->darsOption=$dars;
        //
        return $this->reander('exam-set',
            [
                'model'=>$ExamModel,
                'name'=>'add',
                'examType'=>$this->examType,
                'title'=>'اضافة الجدول الامتحانات '.Application::$app->fun->getTableLearning($this->examType),
            ]
        );
    }
    public function edit(Request $request) {
        $this->examType = $request->getRouteParams()['exam']??'';
        $ExamModel=new Exam();
        $ExamModel->type=$this->examType;
        $ExamModel->lessonsOption=Application::$app->fun->ArrayByValue($ExamModel->lessonsOption);
        $ExamModel->daysOption=Application::$app->fun->ArrayByValue($ExamModel->daysOption);
        
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $ExamModel->loadData($request->getBody());

            if($ExamModel->validate() && $ExamModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/learning/'. $this->examType);
                exit; 
            }
             else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$ExamModel->getOne($id);
            $ExamModel->dars_id=$data['dars_id'];
            $ExamModel->day=$data['day'];
            $ExamModel->lesson=$data['lesson'];
            $ExamModel->time_start=Application::$app->fun->getFullUTS($data['time_start']);
            $ExamModel->time_end=Application::$app->fun->getFullUTS($data['time_end']);
        }
       //
       $DarsModel=new Dars();
       $dars=[];
       foreach($DarsModel->getAllWithDit() as $d)
           $dars[$d['id']]=$d['mname'].'-'.$d['gname'].(!empty($d['dname'])?$d['dname'].'-':'').$d['tname'];       
       
       $ExamModel->darsOption=$dars;
       //
        return $this->reander('exam-set',[
                'model'=>$ExamModel,
                'name'=>'update',
                'examType'=>$this->examType,
                'title'=>'تعديل بيانات جدول الامتحانات '.Application::$app->fun->getTableLearning($this->examType),
            ]
        );
    }
    public function delete(Request $request) {
        $this->examType = $request->getRouteParams()['exam']??'';
        $ExamModel=new Exam();
        if($request->isGet())
        {
            $ExamModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $ExamModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/learning/'. $this->examType);
        exit; 


    }
    public function restore(Request $request) {
        $this->examType = $request->getRouteParams()['exam']??'';
        $ExamModel=new Exam();
        if($request->isGet())
        {
            $ExamModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $ExamModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/learning/'.$this->examType);
        exit; 


    }
}