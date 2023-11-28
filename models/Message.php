<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;

class Message extends Model{
    public $user_id=0;
    public $post_id=0;
    public $post_type='';
    public $message='';
    /**
     * Database Table Info
     */
    public $dbTableName='comment';

    private $dbColums=['user_id','post_id','post_type','message'];

    public function rules():array
    {
        return[
             'message'     =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'message'     =>"اكتب التعليق",
        ];
    }
    public function getByType($type ,$id){

        $D=Application::$app->db->query('SELECT `m`.`id`,
        `m`.`message`,
        `m`.`post_id`,
        `m`.`created` `mcreated`,
        `e`.`name` `ename`,
        `e`.`img` `eimg`,
        `s`.`name` `sname`,
        `s`.`img` `simg`
        FROM '.$this->dbTableName.' `m` 
        left join `employee` `e` on `m`.`user_id` = `e`.`user_id` and `e`.`deleted`=0
        left join `student` `s` on `m`.`user_id` = `s`.`user_id` and `s`.`deleted`=0
        WHERE `m`.`post_type`=? and `m`.`post_id`=? and `m`.`deleted`=0 
        order by `m`.`id` desc',[$type ,$id]);
        return $D;
    }
    public function insert($id ,$type,$message){
        $this->user_id=Application::$app->session->get('user')['user_id'];
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'user_id'       =>$this->user_id,
            'post_id'       =>$id,
            'post_type'     =>$type,
            'message'       =>$message,
            'created'        =>time(),
        ]);
        $this->setLog('message','add',$last_id);

        return $last_id;
    }
    public function remove($id , $type){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id,'post_type'=>$type]);
        $this->setLog('message','remove',$id);
        return $last_id;
    }

}