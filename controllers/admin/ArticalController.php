<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Artical;
use app\models\ArticalPhoto;
class ArticalController extends Controller{

    public function get(Request $request) {
        
        $articalModel=new Artical();
        return $this->reander('articals',[
                'title'=>'صفحة الاخبار',
                'data'=>$articalModel->get(),
            ]
        );
    }
    public function add(Request $request) {
        
        $articalModel=new Artical();
        if($request->isPost())
        {
            $articalModel->loadData($request->getBody());
            if(
                $articalModel->validate() && 
                $articalModel->insert() ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('add'));
                Application::$app->response->redirect('/cp/news');
                exit; 
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        return $this->reander('artical-add',[
                'model'=>$articalModel,
                'name'=>'add',
                'title'=>'اضافة خبر جديد',
            ]
        );
    }
    public function edit(Request $request) {
        $articalModel=new Artical();
        $articalPhotoModel=new ArticalPhoto();
        $data=[];
        $id=$request->getRouteParams()['id']??0;
        if($request->isPost())
        {
            $articalModel->loadData($request->getBody());

            if(
                $articalModel->validate(Without:['imags']) && 
                $articalModel->update($id)){
                    Application::$app->session->setFlash('success',Application::$app->fun->msg('update'));
                Application::$app->response->redirect('/cp/news');
                exit; 
            }
            else
            Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        if($id){
            $data=$articalModel->getOne($id);
            $articalModel->title  =$data['title'];
            $articalModel->content=$data['content'];
            $articalModel->user_id=$data['user_id'];
            $images=$articalPhotoModel->getOne($id);
        }
        return $this->reander('artical-edit',[
                'model'=>$articalModel,
                'images'=>$images,
                'name'=>'edit',
                'title'=>'Edit Artical: '.$articalModel->title,
            ]
        );
    }
    public function delete(Request $request) {
        
        $articalModel=new Artical();
        if($request->isGet())
        {
            $articalModel->loadData($request->getBody());
            $id=$request->getRouteParams()['id']??0;
            if($id && $articalModel->remove($id) ){
                Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
            }
            else
                Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        }
        Application::$app->response->redirect('/cp/news');
        exit; 


    }
    public function delete_photo(Request $request) {
        
        $articalPhotoModel=new ArticalPhoto();
        $articalPhotoModel->loadData($request->getBody());
        $id=$request->getRouteParams()['id']??0;
        if($id && $articalPhotoModel->remove($id) ){
            Application::$app->session->setFlash('success',Application::$app->fun->msg('delete'));
        }
        else
        Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        Application::$app->response->redirect('/cp/news');
        exit; 


    }
    public function ismain_photo(Request $request) {
        
        $articalPhotoModel=new ArticalPhoto();
        $articalPhotoModel->loadData($request->getBody());
        $id=$request->getRouteParams()['id']??0;
        $val=$request->getRouteParams()['val']??0;
        if($id && $articalPhotoModel->updateMain($id,$val) ){
            Application::$app->session->setFlash('success',Application::$app->fun->msg('restore'));
        }
        else
        Application::$app->session->setFlash('error',Application::$app->fun->msg('error'));

        Application::$app->response->redirect('/cp/news');
        exit; 


    } 
}