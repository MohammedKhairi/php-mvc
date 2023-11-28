<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\Division;

class Grade extends Model{
    public $name='';
    public $less_age='';
    public $oldest_age='';
    public $status='';
    /**
     * Database Table Info
     */
    public $dbTableName='grade';

    private $dbColums=['name','less_age','oldest_age','status'];

    public function rules():array
    {
        return[
             'name'         =>[self::RULE_REQUIERD],
             'less_age'     =>[self::RULE_REQUIERD],
             'oldest_age'   =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'name'         =>"اسم الصف",
             'less_age'     =>"اقل عمر",
             'oldest_age'   =>"اكبر عمر",
             'division'     =>"الشعب",
       ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `id`,`name`,`less_age`,`oldest_age`,`deleted` FROM '.$this->dbTableName.'
        WHERE `deleted`=0'.$_p->getLimit());
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`less_age`,`oldest_age`,`deleted` FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`name`,`less_age`,`oldest_age` 
        FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function insert(){
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'name'          =>$this->name,
            'less_age'      =>$this->less_age,
            'oldest_age'    =>$this->oldest_age,
            'created'       =>time(),
        ]);
        $this->setLog('grade','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,[
            'name'          =>$this->name,
            'less_age'      =>$this->less_age,
            'oldest_age'    =>$this->oldest_age,
            ],
            ['id'=>$id]
        );
        $this->setLog('grade','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('grade','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('grade','restore',$id);
        return $last_id;
    }


}