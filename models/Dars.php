<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class Dars extends Model{
    public $grade_id=0;
    public $division_id=0;
    public $emp_id=0;
    public $name='';
    public $num=0;

    public $gradOption=[];
    public $divisionOption=[];
    public $empOption=[];

    /**
     * Database Table Info
     */
    public $dbTableName='dars';

    private $dbColums=['grade_id','division_id','emp_id','name','num'];

    public function rules():array
    {
        return[
             'grade_id'         =>[self::RULE_REQUIERD],
             'division_id'      =>[self::RULE_REQUIERD],
             'emp_id'           =>[self::RULE_REQUIERD],
             'name'             =>[self::RULE_REQUIERD],
             'num'              =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'grade_id'     =>"اسم الصف",
             'division_id'  =>"اسم الشعبة",
             'emp_id'       =>"اسم المعلم",
             'name'         =>"اسم المادة",
             'num'          =>"عدد الحصص في الاسبوع",
       ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `m`.`id`,`m`.`num`,`m`.`name` `mname`,`m`.`deleted`,`g`.`name` `gname`,`d`.`name` `dname`,`t`.`name` `tname`
        FROM '.$this->dbTableName.' `m`
        inner join `grade` `g` on `m`.`grade_id` = `g`.`id` 
        left join `division` `d` on `m`.`division_id` = `d`.`id` 
        inner join `employee` `t` on `m`.`emp_id` = `t`.`id` 
        WHERE `m`.`deleted`=0 and `g`.`deleted`=0  and `t`.`deleted`=0 '.$_p->getLimit());
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`grade_id`,`division_id`,`emp_id`,`name`,`num`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }
    public function getAllWithDit(){
        $D=Application::$app->db->query('SELECT `m`.`id`,
        `m`.`name` `mname`,
        `g`.`name` `gname`,
        `d`.`name` `dname`,
        `t`.`name` `tname`
        FROM '.$this->dbTableName.' `m`
        inner join `grade` `g` on `m`.`grade_id` = `g`.`id` 
        left join `division` `d` on `m`.`division_id` = `d`.`id` 
        inner join `employee` `t` on `m`.`emp_id` = `t`.`id` 
        WHERE `m`.`deleted`=0 and `g`.`deleted`=0  and `t`.`deleted`=0 
        ORDER BY `g`.`id` asc ,`d`.`id` asc
        ');
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`grade_id`,`division_id`,`emp_id`,`name`,`num`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function insert(){
        //
        $this->division_id=empty($this->division_id)?0:$this->division_id;  
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'grade_id'      =>$this->grade_id,
            'division_id'   =>$this->division_id,
            'emp_id'        =>$this->emp_id,
            'name'          =>$this->name,
            'num'           =>$this->num,
            'created'       =>time(),
        ]);
        $this->setLog('dars','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $this->division_id=empty($this->division_id)?0:$this->division_id;  
        $last_id=Application::$app->db->update($this->dbTableName,[
            'grade_id'      =>$this->grade_id,
            'division_id'   =>$this->division_id,
            'emp_id'        =>$this->emp_id,
            'name'          =>$this->name,
            'num'           =>$this->num,
            ],
            ['id'=>$id]
        );
        $this->setLog('dars','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('dars','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('dars','restore',$id);
        return $last_id;
    }


}