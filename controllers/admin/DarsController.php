<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Dars;
use app\models\Division;
use app\models\Employee;
use app\models\Grade;


class DarsController extends Controller{ 
    public function get(Request $request) {
        
        $DarsModel=new Dars();
        return $this->reander('dars',[
                'title'=>'صفحة المواد الدراسيه',
                'data'=>$DarsModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $DarsModel=new Dars();
        if($request->isPost())
        {
            $DarsModel->loadData($request->getBody());
            if($DarsModel->validate(['division_id']) && $DarsModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/dars');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        //
        $GradeModel=new Grade();
        $DivisionModel=new Division();
        $EmployeeModel=new Employee();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();
        $employes=$EmployeeModel->getAll();

        $DarsModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $DarsModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');
        $DarsModel->empOption=Application::$app->fun->OrderdArray($employes,'id','name');
        //
        return $this->reander('dars-set',
            [
                'model'=>$DarsModel,
                'name'=>'add',
                'title'=>'اضافة مادة جديدة',
            ]
        );
    }
    public function edit(Request $request) {
         
        $DarsModel=new Dars();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $DarsModel->loadData($request->getBody());

            if($DarsModel->validate(['division_id']) && $DarsModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/dars');
                exit; 
            }
             else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$DarsModel->getOne($id);
            $DarsModel->grade_id=$data['grade_id'];
            $DarsModel->division_id=$data['division_id'];
            $DarsModel->emp_id=$data['emp_id'];
            $DarsModel->name=$data['name'];
            $DarsModel->num=$data['num'];
        }
        //
        //
        $GradeModel=new Grade();
        $DivisionModel=new Division();
        $EmployeeModel=new Employee();

        $grades=$GradeModel->getAll();
        $divisions=$DivisionModel->getAll();
        $employes=$EmployeeModel->getAll();

        $DarsModel->gradOption=Application::$app->fun->OrderdArray($grades,'id','name');
        $DarsModel->divisionOption=Application::$app->fun->OrderdArray($divisions,'id','name');
        $DarsModel->empOption=Application::$app->fun->OrderdArray($employes,'id','name');
        //
        //
        return $this->reander('dars-set',[
                'model'=>$DarsModel,
                'name'=>'update',
                'title'=>'تعديل بيانات المادة: '.$data['name']??'',
            ]
        );
    }
    public function delete(Request $request) {
        
        $DarsModel=new Dars();
        if($request->isGet())
        {
            $DarsModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $DarsModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/dars');
        exit; 


    }
    public function restore(Request $request) {
        
        $DarsModel=new Dars();
        if($request->isGet())
        {
            $DarsModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $DarsModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/dars');
        exit; 


    }
}