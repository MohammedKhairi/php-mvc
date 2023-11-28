<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Employee;

class EmployeeController extends Controller{ 
    public function get(Request $request) {
        
        $EmployeeModel=new Employee();
        return $this->reander('employes',[
                'title'=>'صفحة الموظفين',
                'data'=>$EmployeeModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $EmployeeModel=new Employee();
        if($request->isPost())
        {
            $EmployeeModel->loadData($request->getBody());
            if($EmployeeModel->validate() && $EmployeeModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/employee');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }

        return $this->reander('employee-set',[
                'model'=>$EmployeeModel,
                'name'=>'add',
                'title'=>'اضافة موظف جديد',
            ]
        );
    }
    public function edit(Request $request) {
         
        $EmployeeModel=new Employee();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $EmployeeModel->loadData($request->getBody());
            if($EmployeeModel->validate(['img']) && $EmployeeModel->update($id))
            {
                Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/employee');
                exit; 
            }
             else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        #get Data
    
        if($id){
            $data=$EmployeeModel->getOneById($id);
            $EmployeeModel->name=$data['name'];
            $EmployeeModel->phone=$data['phone'];
            $EmployeeModel->img=$data['img'];
            $EmployeeModel->birthday=Application::$app->fun->getUTS($data['birthday']);
            $EmployeeModel->province=$data['province'];
            $EmployeeModel->address=$data['address'];
            $EmployeeModel->mothe_rname=$data['mothe_rname'];
            $EmployeeModel->idcard=$data['idcard'];
            $EmployeeModel->hiring_date=Application::$app->fun->getUTS($data['hiring_date']);
            $EmployeeModel->direct_date=Application::$app->fun->getUTS($data['direct_date']);
        }
        return $this->reander('employee-set',[
                'model'=>$EmployeeModel,
                'name'=>'update',
                'title'=>'تعديل بيانات الموظف: '.$data['name']??'',
            ]
        );
    }
    public function delete(Request $request) {
        
        $EmployeeModel=new Employee();
        if($request->isGet())
        {
            $EmployeeModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $EmployeeModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/employee');
        exit; 


    }
    public function restore(Request $request) {
        
        $EmployeeModel=new Employee();
        if($request->isGet())
        {
            $EmployeeModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $EmployeeModel->restore($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/employee');
        exit; 


    }
}