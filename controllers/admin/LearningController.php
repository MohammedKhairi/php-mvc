<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Dars;
use app\models\Learning;


class LearningController extends Controller{ 
    public function get(Request $request) {
        $LearningModel=new Learning();
        return $this->reander('week',[
                'title'=>'صفحة الجدول الاسبوعي',
                'data'=>$LearningModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $LearningModel=new Learning();
        $LearningModel->lessonsOption=Application::$app->fun->ArrayByValue($LearningModel->lessonsOption);
        $LearningModel->daysOption=Application::$app->fun->ArrayByValue($LearningModel->daysOption);
        if($request->isPost())
        {
            $LearningModel->loadData($request->getBody());
            if($LearningModel->validate() && $LearningModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/learning/week');
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
        
        $LearningModel->darsOption=$dars;
        //
        return $this->reander('week-set',
            [
                'model'=>$LearningModel,
                'name'=>'add',
                'title'=>'اضافة الجدول الاسبوعي',
            ]
        );
    }
    public function edit(Request $request) {
         
        $LearningModel=new Learning();
        $LearningModel->lessonsOption=Application::$app->fun->ArrayByValue($LearningModel->lessonsOption);
        $LearningModel->daysOption=Application::$app->fun->ArrayByValue($LearningModel->daysOption);
        
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $LearningModel->loadData($request->getBody());

            if($LearningModel->validate() && $LearningModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/learning/week');
                exit; 
            }
             else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$LearningModel->getOne($id);
            $LearningModel->dars_id=$data['dars_id'];
            $LearningModel->day=$data['day'];
            $LearningModel->lesson=$data['lesson'];
            $LearningModel->time_start=Application::$app->fun->getFullUTS($data['time_start']);
            $LearningModel->time_end=Application::$app->fun->getFullUTS($data['time_end']);
        }
       //
       $DarsModel=new Dars();
       $dars=[];
       foreach($DarsModel->getAllWithDit() as $d)
       $dars[$d['id']]=$d['mname'].' - '.$d['gname'].' - '.(!empty($d['dname'])?$d['dname'].' - ':'').$d['tname'];       
       
       $LearningModel->darsOption=$dars;
       //
        return $this->reander('week-set',[
                'model'=>$LearningModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الجدول الاسبوعي',
            ]
        );
    }
    public function delete(Request $request) {
        
        $LearningModel=new Learning();
        if($request->isGet())
        {
            $LearningModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $LearningModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/learning/week');
        exit; 


    }
    public function restore(Request $request) {
        
        $LearningModel=new Learning();
        if($request->isGet())
        {
            $LearningModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $LearningModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/learning/week');
        exit; 


    }
}