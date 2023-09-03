<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Image;
use app\core\Request;
use app\models\Category;

class CategoryController extends Controller{   
    public function __construct() {
        $this->setLayout('admin');
        $this->setPrevPage('/admin');
    }
    public function get(Request $request) {
        
        $categoryModel=new Category();
        return $this->reander('categories',[
                'title'=>'Category Page',
                'data'=>$categoryModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $categoryModel=new Category();
        if($request->isPost())
        {
            $categoryModel->loadData($request->getBody());

            if($categoryModel->validate() && $categoryModel->insert() ){
                Application::$app->session->setFlash('success','Category Add Successfuly');
                Application::$app->response->redirect('/cp/category');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }

        return $this->reander('category-set',[
                'model'=>$categoryModel,
                'name'=>'add',
                'title'=>'Add New Category',
            ]
        );
    }
    public function edit(Request $request) {
         
        $categoryModel=new Category();
        $data=[];
        $id=$request->getRouteParams()['id']??0;

        #Save Change
        if($request->isPost())
        {
            $categoryModel->loadData($request->getBody());

            if(
               // $categoryModel->validate() && 
                $categoryModel->update($id) )
            {
                Application::$app->session->setFlash('success','Category Update Successfuly');
                Application::$app->response->redirect('/cp/category');
                exit; 
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        #get Data
    
        if($id){
            $data=$categoryModel->getOne($id);
            $categoryModel->name=$data['name'];
            $categoryModel->title=$data['title'];
            $categoryModel->nav=$data['nav'];
            $categoryModel->order=$data['order'];
            $categoryModel->img=$data['img'];
        }
        return $this->reander('category-set',[
                'model'=>$categoryModel,
                'name'=>'update',
                'title'=>'Edit Category: '.$data['name']??0,
            ]
        );
    }
    public function delete(Request $request) {
        
        $categoryModel=new Category();
        if($request->isGet())
        {
            $categoryModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $categoryModel->remove($id) ){
                Application::$app->session->setFlash('success','Category Deleted Successfuly');
            }
            else
            Application::$app->session->setFlash('error','Some Think Wrong ! Pless try Agin');

        }
        Application::$app->response->redirect('/cp/category');
        exit; 


    }
}