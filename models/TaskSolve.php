<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;

class TaskSolve extends Model{
    public $task_id=0;
    public $std_id=0;
    public $content='';
    public $filename='';
    /**
     * Database Table Info
     */
    public $dbTableName='task_solve';

    private $dbColums=['task_id','std_id','content','filename'];

    public function rules():array
    {
        return[
             'task_id' =>[self::RULE_REQUIERD],
             'std_id'  =>[self::RULE_REQUIERD],
             'content'  =>[self::RULE_REQUIERD],
             'filename'=>[self::RULE_REQUIERD,[self::RULE_FILE,'exe'=>['png','jpg']]],
        ];
    }
    public function lables():array{
        return[
             'task_id'      =>"المهمة",
             'std_id'       =>"الطالب",
             'content'      =>"الحل",
             'filename'     =>"الملفات",
        ];
    }
    public function getOneById($id){
        $D=Application::$app->db->row('SELECT `id`, 
        `task_id`, 
        `std_id`, 
        `content`, 
        `filename`, 
        `created`, 
        `updated` 
        FROM '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function getAllById($id){
        $D=Application::$app->db->query('SELECT `id`, 
        `task_id`, 
        `std_id`, 
        `content`, 
        `filename`, 
        `created`, 
        `updated` 
        FROM '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function getAllByTask($task_id){
        $this->params[]=$task_id;
        #
        $std=Application::$app->session->get('user');
        #
        if("student" ==$std['lvl']){
            $this->whr=' and `s`.`id`=?';
            $this->params[]=$std['id'];
        }

        $D=Application::$app->db->query('SELECT `st`.`id` `sid`,
        `st`.`task_id`,
        `st`.`content`,
        `st`.`filename`,
        `st`.`created` `st_created`,
        `st`.`updated`,
        `t`.`task`,
        `t`.`deliver_date`,
        `t`.`emp_id`,
        `t`.`grade_id`,
        `t`.`dars_id`,
        `s`.`name` `sname`,
        `s`.`img` `simg`
        FROM '.$this->dbTableName.' `st`
        inner join `task` `t` on  `st`.`task_id` =`t`.`id` and `t`.`deleted`=0
        inner join `student` `s` on  `st`.`std_id` =`s`.`id` and `s`.`deleted`=0
        WHERE `st`.`task_id`=?'.$this->whr,$this->params);
        return $D;
    }
    public function getOneByTask($task_id){
        $this->params[]=$task_id;
        #
        $std=Application::$app->session->get('user');
        #
        if("student" ==$std['lvl']){
            $this->whr=' and `s`.`id`=?';
            $this->params[]=$std['id'];
        }

        $D=Application::$app->db->row('SELECT `st`.`id` `sid`,
        `st`.`task_id`,
        `st`.`content`,
        `st`.`filename`,
        `st`.`created` `st_created`,
        `st`.`updated`,
        `t`.`task`,
        `t`.`deliver_date`,
        `t`.`emp_id`,
        `t`.`grade_id`,
        `t`.`dars_id`,
        `s`.`name` `sname`,
        `s`.`img` `simg`
        FROM '.$this->dbTableName.' `st`
        inner join `task` `t` on  `st`.`task_id` =`t`.`id` and `t`.`deleted`=0
        inner join `student` `s` on  `st`.`std_id` =`s`.`id` and `s`.`deleted`=0
        WHERE `st`.`task_id`=?'.$this->whr,$this->params);
        return $D;
    }
    public function insert(){
        $this->task_id=Application::$app->request->getRouteParams()['id']??0;
        $this->std_id=Application::$app->session->get('user')['id'];
        $filename='';
        if($this->filename['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->filename,dst_w:500,dst_h:500);
        }
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'task_id'       =>$this->task_id,
            'std_id'        =>$this->std_id,
            'content'       =>$this->content,
            'filename'      =>$filename,
            'created'       =>time(),
        ]);
        $this->setLog('task_solve','add',$last_id);
        return $last_id;
    }

}