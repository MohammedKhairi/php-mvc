<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Department extends Model{
    public $title='';
    public $name='';
    /**
     * Database Table Info
     */
    public $dbTableName='department';

    private $dbColums=['title','name'];

    public function rules():array
    {
        return[
             'title'      =>[self::RULE_REQUIERD],
             'name'       =>[self::RULE_REQUIERD,[self::RULE_UNIQUE,'class'=>self::class]],
        ];
    }
    public function lables():array{
        return[
            'title'      =>'Department Title',
            'name'       =>'Department Slag',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->tableName(),[
            'title'=>$this->title,
            'name'=>$this->name,
            'created'=>time(),
        ]);
        return $last_id;
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`title`,`deleted` From '.$this->tableName());
        return $D;
    }

}