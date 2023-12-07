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
    public function getAlert($ulvl,$uid,$user_id=0){
        $D=[];
        if("student"== $ulvl){
            
            $this->whr.=" AND `l`.`action`=? AND `s`.`id`=? ";
            $this->params[]="alert";
            $this->params[]="task";
            $this->params[]="add";
            $this->params[]=$uid;
            #
            $D=Application::$app->db->query('SELECT `l`.`id` `lid`, 
            `l`.`program`,
            `l`.`post_id`,
            `l`.`action`,
            `e`.`name` `ename`, 
            `e`.`img` `eimg`, 
            `t`.`task`,
            `t`.`id` `tid`,
            `a`.`content` `acontent`,
            `a`.`id` `aid`
            FROM '.$this->dbTableName.' `l` 
            inner join `employee` `e` on `l`.`user_id`= `e`.`user_id` and `e`.`deleted`=0
            left join `alert` `a` on `l`.`post_id`= `a`.`id` and `a`.`deleted`=0 and `l`.`program`=?
            left join `task` `t` on `l`.`post_id`= `t`.`id`  and `t`.`deleted`=0 and `l`.`program`=?
            inner join `student` `s` on (`a`.`grade_id`= `s`.`grade_id` or  `t`.`grade_id`= `s`.`grade_id` )and `s`.`deleted`=0
            WHERE 1 '.$this->whr." order by `l`.`id` desc limit 0,5",$this->params);
            #
            #vd($D);exit;
        }
        else if("employee"== $ulvl){


            $this->params[]=$uid;
            $this->params[]=$uid;

            $this->params[]="student";
            
            $this->whr.=" AND (`c`.`post_type`=? OR `c`.`post_type`=? )";
            
            $this->params[]="alert";
            $this->params[]="task";
            #
            $D=Application::$app->db->query('SELECT `c`.`post_type`,
            `c`.`post_id`,
            `c`.`comment`,
            `s`.`name` `sname`, 
            `s`.`img` `simg`
            FROM `comment` `c`
            left join `alert` `a` on `c`.`post_id`= `a`.`id` and `a`.`deleted`=0 and `a`.`emp_id`=?
            left join `task` `t` on `c`.`post_id`= `t`.`id`  and `t`.`deleted`=0 and `t`.`emp_id`=?
            inner join `user` `u` on `c`.`user_id`= `u`.`id`  and `u`.`deleted`=0 and `u`.`lvl`=?
            inner join `student` `s` on `u`.`id`= `s`.`user_id`  and `s`.`deleted`=0
            WHERE 1 '.$this->whr." order by `c`.`id` desc limit 0,5",$this->params);
            #
            // vd($D);exit;
        }
        else{
            $this->whr.=" AND (`l`.`program`=? OR `l`.`program`=? OR `l`.`program`=? ) AND (`l`.`action`=? OR `l`.`action`=? ) ";
            
            $this->params[]="alert";
            $this->params[]="task";
            $this->params[]="news";

            $this->params[]="comment";
            $this->params[]="add";
            #
            $D=Application::$app->db->query('SELECT `l`.`id` `lid`, 
            `l`.`program`,
            `l`.`post_id`,
            `l`.`action`,
            `e`.`name` `ename`, 
            `e`.`img` `eimg`
            FROM '.$this->dbTableName.' `l` 
            inner join `employee` `e` on `l`.`user_id`= `e`.`user_id`  and `e`.`deleted`=0
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