<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Chat;

class ChatController extends Controller{
    public function __construct() {
        // $this->setLayout('admin');
        // $this->setPrevPage('/admin');
    }
    public function get(){
        //$this->setTitle('Dashboard Page');
        return $this->reander('chat',['title'=>'صفحه المحادثات']);
    }  

    public function getUsers(){
        $ChatModel=new Chat();

        $users=$ChatModel->getUsers();
        return json_encode([
            "users"=>$users
        ]);
    }   
    public function getChats(Request $request){
        $id=$request->getBody()['id']??0;
        $myid=$request->getBody()['myid']??0;
        
        $ChatModel=new Chat();
        $chats=$ChatModel->getOneInfo($id,$myid);
        return json_encode([
            "chats"=>$chats
        ]);
    }   
    
    public function add(Request $request){
        $ChatModel=new Chat();
        if($request->isPost())
        {
            $ChatModel->loadData($request->getBody());
            if($ChatModel->insert() )
                return json_encode(["msg"=>"Message is send","error"=>0]);
            else
                return json_encode(["msg"=>"Error !. Message is here","error"=>1]);


        }

    }   
     
}