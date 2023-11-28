<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class User extends Model{
    public $code='';
    public $pass='';
    public $lvl='';
    public $register='';
    /**
     * Database Table Info
     */
    public $dbTableName='user';

    private $dbColums=['code','pass','lvl','register'];

    public function rules():array
    {
        return[
             'code'      =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>6],[self::RULE_MAX,'max'=>8]],
             'pass'      =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>6],[self::RULE_MAX,'max'=>8]],
             'lvl'       =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'code'      =>'User Name',
            'pass'      =>'Password',
            'lvl'       =>'User Level',
       ];
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `code`,`pass`,`lvl` FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `code`,`pass`,`lvl` FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function getOneCode($code){
        $D=Application::$app->db->row('SELECT `code`,
        `pass`,
        `lvl` 
        FROM '.$this->dbTableName.
        ' WHERE `deleted`=0 and `code` like ? 
        order by id desc',[$code.'%']);
        return $D;
    }
    public function insert($type){
        $d=$this->getOneCode($type);
        //Student Data
        if($type=="std"){
            $this->lvl='student';
        }
        //Employee Data
        if($type=="emp"){
            $this->lvl='employee';
        }
        //
        $this->pass=Application::$app->fun->rand_string(8);
        //
        if(empty($d)){
            $this->code=$type.'1';
        }
        else{
            $l=substr($d['code'],3,strlen($d['code'])-1);  
            $this->code=$type.($l+1);
        }
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'code'=>$this->code,
            'pass'=>$this->pass,
            'lvl'=>$this->lvl,
            'created'=>time(),
        ]);
        $this->setLog('user','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,[
            'code'=>$this->code,
            'pass'=>$this->pass,
            'lvl'=>$this->lvl,
            ],
            ['id'=>$id]
        );
        $this->setLog('user','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('user','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('user','restore',$id);
        return $last_id;
    }


}