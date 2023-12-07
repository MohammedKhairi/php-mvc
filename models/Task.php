<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;
use app\models\TaskDivision;


class Task extends Model{
    public $emp_id=0;
    public $grade_id=0;
    public $dars_id=0;
    public $deliver_date=0;
    public $is_comment=1;
    public $division_id;
    public $task='';
    public $gradOption= [];
    public $divisionOption= [];
    public $darsOption= [];
    public $commentOption= ["1"=>"مفعل","0"=>"مغلق"];
    /**
     * Database Table Info
     */
    public $dbTableName='task';

    private $dbColums=['emp_id','grade_id','division_id','task','dars_id','deliver_date','is_comment'];

    public function rules():array
    {
        return[
            //  'emp_id'      =>[self::RULE_REQUIERD],
             'grade_id'     =>[self::RULE_REQUIERD],
            //  'division_id'  =>[self::RULE_REQUIERD],
             'task'         =>[self::RULE_REQUIERD],
             'dars_id'      =>[self::RULE_REQUIERD],
             'deliver_date' =>[self::RULE_REQUIERD],
             'is_comment'   =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'grade_id'     =>"الصف",
             'division_id'  =>"الشعبة",
             'task'         =>"المهمة",
             'dars_id'      =>"الدرس",
             'deliver_date' =>"وقت تسليم المهمة",
             'is_comment'   =>"حالة التعاليق",
        ];
    }
    public function get(){
        $this->setOrder();
        #
        $_p=$this->Pagination();
        #
        $D=Application::$app->db->query('SELECT `t`.`task`,
        `t`.`id` `tid`,
        `t`.`deleted`,
        `t`.`deliver_date`,
        `t`.`is_comment`,
        (SELECT count(`d`.`name`) FROM `task_division` `td`
        inner join `division` `d` on  `td`.`division_id` =`d`.`id`
        WHERE `task_id`=`tid`) `dnumber`,
        `m`.`name` `mname`,
        `g`.`name` `gname`,
        `e`.`name` `ename`
        FROM '.$this->dbTableName.' `t`
        inner join `dars` `m` on `t`.`dars_id` = `m`.`id` 
        inner join `grade` `g` on `t`.`grade_id` = `g`.`id` 
        inner join `employee` `e` on `t`.`emp_id` = `e`.`id` 
        WHERE `t`.`deleted`=0 '.$this->whr.$_p->getLimit(),$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $this->setOrder();
        $D=Application::$app->db->query('SELECT `t`.`id`,
        `t`.`emp_id`,
        `t`.`grade_id`,
        `t`.`task`,
        `t`.`dars_id`,
        `t`.`deliver_date`,
        `t`.`is_comment`,
        `t`.`deleted` 
        FROM '.$this->dbTableName.' `t` WHERE `t`.`deleted`=0'.$this->whr, $this->params);
        return $D;
    }
    public function getOne($id){

        $this->setOrder();
        #
        $this->whr.=' AND `t`.`id`=? ';
        $this->params[]=$id;  
        #
        $D=Application::$app->db->row('SELECT `t`.`task`,
        `t`.`id` `tid`,
        `t`.`deleted`,
        `t`.`deliver_date`,
        `t`.`is_comment`,
        `t`.`emp_id`,
        `t`.`dars_id`,
        `t`.`grade_id`,
        `t`.`id`,
        `m`.`name` `mname`,
        `g`.`name` `gname`,
        `e`.`name` `ename`
        FROM '.$this->dbTableName.' `t`
        inner join `dars` `m` on `t`.`dars_id` = `m`.`id` 
        inner join `grade` `g` on `t`.`grade_id` = `g`.`id` 
        inner join `employee` `e` on `t`.`emp_id` = `e`.`id` 
        WHERE `t`.`deleted`=0 '.$this->whr,$this->params);
        return $D;
    }
    public function getOneInfo($id){
        #
        $this->setOrder();
        #
        $this->whr.=' AND `t`.`id`=? ';
        $this->params[]=$id;  
        #
        $D=Application::$app->db->row('SELECT `t`.`task`,
        `t`.`id` `tid`,
        `t`.`deleted`,
        `t`.`deliver_date`,
        `t`.`is_comment`,
        `m`.`name` `mname`,
        `g`.`name` `gname`,
        `e`.`name` `ename`
        FROM '.$this->dbTableName.' `t`
        inner join `dars` `m` on `t`.`dars_id` = `m`.`id` 
        inner join `grade` `g` on `t`.`grade_id` = `g`.`id` 
        inner join `employee` `e` on `t`.`emp_id` = `e`.`id` 
        WHERE `t`.`deleted`=0 '.$this->whr,$this->params);
        return $D;
    }
    public function insert(){
        $this->emp_id=Application::$app->session->get('user')['id'];
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'emp_id'       =>$this->emp_id,
            'grade_id'     =>$this->grade_id,
            'dars_id'      =>$this->dars_id,
            'task'         =>$this->task,
            'deliver_date' =>strtotime($this->deliver_date),
            'is_comment'   =>$this->is_comment,
            'created'      =>time(),
        ]);
        
        if(!empty($last_id) && !empty($this->division_id)){
            $taskDivision=new TaskDivision();
            foreach ($this->division_id as $v) {
                $taskDivision->task_id=$last_id;
                $taskDivision->division_id=$v;
                $taskDivision->insert();
            }
        }
        $this->setLog('task','add',$last_id);
        return $last_id;
    }
    public function update($id){  
        $last_id=Application::$app->db->update($this->dbTableName,[
            'grade_id'     =>$this->grade_id,
            'dars_id'      =>$this->dars_id,
            'task'         =>$this->task,
            'deliver_date' =>strtotime($this->deliver_date),
            'is_comment'   =>$this->is_comment,
            ],
            ['id'=>$id]
        );
        //
        if(!empty($id) && !empty($this->division_id)){
            $taskDivision=new TaskDivision();
            $taskDivision->removeByTaskId($id);   
            foreach ($this->division_id as $v) {
                $taskDivision->task_id=$id;
                $taskDivision->division_id=$v;
                $taskDivision->insert();
            }
        }
        $this->setLog('task','edit',$id);
        return $last_id;
    }
    public function remove($id){
        if(!$this->isBelong($id))
            return false;
        //
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('task','remove',$id);
        return $last_id;
    }
    public function restore($id){
        if(!$this->isBelong($id))
            return false;
        //
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('task','restore',$id);
        return $last_id;
    }
    public function setOrder(){  
        $user=Application::$app->session->get('user');
        #
        $user_lvl=$user['lvl'];
        $user_uid=$user['user_id'];
        $user_id=$user['id'];
        #
        if("employee"==$user_lvl){
            $this->whr.=' and `t`.`emp_id`=? ';
            $this->params[]=$user_id;
        }
        elseif("student"==$user_lvl){
            $StudentModel=new Student();
            $std=$StudentModel->getOneById($user_id);
            $this->whr.=' and `t`.`grade_id`=? ';
            $this->params[]=$std['grade_id'];
            #

            #
        }
        return true;
    }
    public function isBelong($id){  
        if($this->getOne($id))
            return true;
        else
            return false;

    }


}