<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Division;
use app\models\Grade;


class DivisionController extends Controller{ 
    public function get(Request $request) {
        
        $DivisionModel=new Division();
        return $this->reander('divisions',[
                'title'=>'صفحة الشعب',
                'data'=>$DivisionModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $DivisionModel=new Division();
        if($request->isPost())
        {
            $DivisionModel->loadData($request->getBody());
            if($DivisionModel->validate() && $DivisionModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/grade/division');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        $GradeModel=new Grade();
        $grades=$GradeModel->getAll();
        $DivisionModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        //
        return $this->reander('division-set',
            [
                'model'=>$DivisionModel,
                'name'=>'add',
                'title'=>'اضافة شعبة جديدة',
            ]
        );
    }
    public function edit(Request $request) {
         
        $DivisionModel=new Division();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $DivisionModel->loadData($request->getBody());

            if($DivisionModel->validate() && $DivisionModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/grade/division');
                exit; 
            }
             else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$DivisionModel->getOne($id);
            $DivisionModel->name=$data['name'];
            $DivisionModel->grade_id=$data['grade_id'];
        }
        //
        $GradeModel=new Grade();
        $grades=$GradeModel->getAll();
        $DivisionModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        //
        return $this->reander('division-set',[
                'model'=>$DivisionModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الشعبة: '.$data['name']??'',
            ]
        );
    }
    public function delete(Request $request) {
        
        $DivisionModel=new Division();
        if($request->isGet())
        {
            $DivisionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $DivisionModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/grade/division');
        exit; 


    }
    public function restore(Request $request) {
        
        $DivisionModel=new Division();
        if($request->isGet())
        {
            $DivisionModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $DivisionModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/grade/division');
        exit; 


    }
}