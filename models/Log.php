<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class Log extends Model{
    public $user_id=0;
    public $program='';
    public $action='';
    public $post_id=0;
    /**
     * Database Table Info
     */
    public $dbTableName='log';

    private $dbColums=['user_id','program','action','post_id'];

    public function rules():array
    {
        return[
             'user_id' =>[self::RULE_REQUIERD],
             'program' =>[self::RULE_REQUIERD],
             'action'  =>[self::RULE_REQUIERD],
             'post_id' =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'user_id'      =>"اسم المستخدم",
             'program'      =>"اسم البرنامج",
             'action'       =>"اسم العملية",
             'post_id'      =>"رقم المحتوى",
       ];
    }
    public function get(){
        $D=[];
        $D=Application::$app->db->query(' SELECT `id`, 
        `user_id`, 
        `program`, 
        `action`, 
        `post_id`, 
        `created` 
        FROM '.$this->dbTableName.' WHERE 1 '.$this->whr,$this->params);
        return $D;
    }
    public function getAlert($ulvl,$uid){
        $D=[];
        if("student"== $ulvl){
            $this->whr.=" AND `l`.`program`=? AND `l`.`action`=? AND `s`.`id`=? ";
            $this->params[]="alert";
            $this->params[]="add";
            $this->params[]=$uid;
            #
            $D=Application::$app->db->query('SELECT `l`.`id` `lid`, 
            `e`.`name` `ename`, 
            `e`.`img` `eimg`, 
            `a`.`content` `acontent`,
            `a`.`id` `aid`
            FROM '.$this->dbTableName.' `l` 
            inner join `employee` `e` on `l`.`user_id`= `e`.`user_id` and `e`.`deleted`=0
            inner join `alert` `a` on `l`.`post_id`= `a`.`id`  and `a`.`deleted`=0
            inner join `student` `s` on `a`.`grade_id`= `s`.`grade_id` and `s`.`deleted`=0
            WHERE 1 '.$this->whr." order by `l`.`id` desc limit 0,5",$this->params);


        }
        else if("employee"== $ulvl){

        }
        else{
            $this->whr.=" AND `l`.`program`=? AND `l`.`action`=? ";
            $this->params[]="alert";
            $this->params[]="add";
            #
            $D=Application::$app->db->query('SELECT `l`.`id` `lid`, 
            `e`.`name` `ename`, 
            `e`.`img` `eimg`, 
            `a`.`content` `acontent`,
            `a`.`id` `aid`
            FROM '.$this->dbTableName.' `l` 
            inner join `employee` `e` on `l`.`user_id`= `e`.`user_id`  and `e`.`deleted`=0
            inner join `alert` `a` on `l`.`post_id`= `a`.`id`  and `a`.`deleted`=0
            WHERE 1 '.$this->whr." order by `l`.`id` desc limit 0,5",$this->params);
        }
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`, `user_id`, `program`, `action`, `post_id`, `created` FROM '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function insert($user_id,$program,$action,$post_id){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'user_id'   =>$user_id,
            'program'   =>$program,
            'action'    =>$action,
            'post_id'   =>$post_id,
            'created'   =>time(),
        ]);
        return $last_id;
    }
}