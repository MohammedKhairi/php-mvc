<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Request;

class Exam extends Model{
    public $dars_id=0;
    public $day='';
    public $lesson='';
    public $type='';
    public $time_start=0;
    public $time_end=0;

    public $darsOption=[];
    public $daysOption=["الاحد","الاثنين","الثلاثاء","الاربعاء","الخميس","الجمعه","السبت"];
    public $lessonsOption=["الاول","الثاني","الثالث","الرابع","الخامس","السادس"];
    /**
     * Database Table Info
     */
    public $dbTableName='learning';

    private $dbColums=['dars_id','type','day','lesson','time_start','time_end'];

    public function rules():array
    {
        return[
             'dars_id'      =>[self::RULE_REQUIERD],
             'day'          =>[self::RULE_REQUIERD],
             'lesson'       =>[self::RULE_REQUIERD],
             'time_start'   =>[self::RULE_REQUIERD],
             'time_end'     =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'dars_id'      =>"اسم المادة",
             'day'          =>"اليوم",
             'lesson'       =>"الدرس",
             'time_start'   =>"وقت البداية الامتحان",
             'time_end'     =>"وقت النهاية الامتحان",
        ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `d`.`name` `dname`,`l`.`id`,`l`.`day`,`l`.`lesson`,`l`.`time_start`,`l`.`type`,`l`.`time_end`,`l`.`deleted`
        FROM '.$this->dbTableName.' `l`
        inner join `dars` `d` on `l`.`dars_id` = `d`.`id` 
        WHERE `d`.`deleted`=0 and `l`.`deleted`=0 and `type`=? '.$_p->getLimit(),[$this->type]);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`dars_id`,`day`,`lesson`,`time_start`,`time_end`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `type`=?',[$this->type]);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT  `id`,`dars_id`,`day`,`lesson`,`time_start`,`time_end`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=? and `type`=?',[$id,$this->type]);
        return $D;
    }
    public function insert(){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'dars_id'       =>$this->dars_id,
            'day'           =>$this->day,
            'lesson'        =>$this->lesson,
            'time_start'    =>strtotime($this->time_start),
            'time_end'      =>strtotime($this->time_end),
            'type'          =>$this->type,
            'created'       =>time(),
        ]);
        $this->setLog('exam','add',$last_id);
        return $last_id;
    }
    public function update($id){  
        $last_id=Application::$app->db->update($this->dbTableName,[
            'dars_id'       =>$this->dars_id,
            'day'           =>$this->day,
            'lesson'        =>$this->lesson,
            'time_start'    =>strtotime($this->time_start),
            'time_end'      =>strtotime($this->time_end),
            ],
            ['id'=>$id]
        );
        $this->setLog('exam','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('exam','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('exam','restore',$id);
        return $last_id;
    }


}