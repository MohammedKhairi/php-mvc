<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Division extends Model{
    public $grade_id='';
    public $name='';
    public $gradOption =[];
    /**
     * Database Table Info
     */
    public $dbTableName='division';

    private $dbColums=['name','grade_id'];

    public function rules():array
    {
        return[
             'name'         =>[self::RULE_REQUIERD],
             'grade_id'     =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'name'         =>"اسم الشعبه",
             'grade_id'     =>"اسم الصف",
       ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `d`.`id`,`d`.`name` `dname`,`d`.`grade_id`,`d`.`deleted`,`g`.`name` `gname` 
        FROM '.$this->dbTableName.' `d`
        inner join `grade` `g` on `d`.`grade_id`=`g`.`id`
        WHERE `d`.`deleted`=0 and `g`.`deleted`=0
        order by `g`.`id` asc
        '.$_p->getLimit());
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`name`,`grade_id`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`grade_id`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 order by `grade_id` asc');
        return $D;
    }
    public function getOneByGrade($grade_id){
        $D=Application::$app->db->row('SELECT `id`,`name`,`grade_id`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `grade_id`=?',[$grade_id]);
        return $D;
    }
    public function getByGrade($grade_id){
        $D=Application::$app->db->query('SELECT `id`,`name`,`grade_id`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `grade_id`=?',[$grade_id]);
        return $D;
    }
    public function insert(){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'name'          =>$this->name,
            'grade_id'      =>$this->grade_id,
        ]);
        $this->setLog('division','add',$last_id);
        return $last_id;
    }
    public function insertWithGrade($grade_id,$name){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'grade_id'      =>$grade_id,
            'name'          =>$name,
        ]);
        $this->setLog('division','add',$last_id);
        return $last_id;
    }
    public function update($id){

        $last_id=Application::$app->db->update($this->dbTableName,[
            'name'          =>$this->name,
            'grade_id'      =>$this->grade_id,
            ],
            ['id'=>$id]
        );
        $this->setLog('division','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('division','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('division','restore',$id);
        return $last_id;
    }


}