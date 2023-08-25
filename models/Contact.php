<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Contact extends Model{
    public $email='';
    public $name='';
    public $body='';
    public $dep_id='';
    /**
     * Database Table Info
     */
    public $dbTableName='contacts';

    private $dbColums=['email','name','body'];

    public function rules():array
    {
        return[
             'email'      =>[self::RULE_REQUIERD,self::RULE_EMAIL],
             'name'       =>[self::RULE_REQUIERD],
             'body'       =>[self::RULE_REQUIERD],
             'dep_id' =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'email'      =>'Email',
            'name'       =>'You Name',
            'body'       =>'Message',
            'dep_id'     =>'Department',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'name'=>$this->name,
            'email'=>$this->email,
            'body'=> $this->body,
            'dep_id'=> $this->dep_id,
            'created'=>time(),
        ]);
        return $last_id;
    }

}