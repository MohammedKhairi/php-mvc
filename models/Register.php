<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Register extends Model{
    public $firstname='';
    public $lastname='';
    public $email='';
    public $password='';
    public $confirmPassword='';
    /**
     * Database Table Info
     */
    public $dbTableName='users';

    private $dbColums=['firstname','lastname','email','password'];

    public function rules():array
    {
        return[
             'firstname'      =>[self::RULE_REQUIERD],
             'lastname'       =>[self::RULE_REQUIERD],
             'email'          =>[self::RULE_REQUIERD,self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>self::class]],
             'password'       =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>5],[self::RULE_MAX,'max'=>24]],
             'confirmPassword'=>[self::RULE_REQUIERD,[self::RULE_MATCH,'match'=>'password']],
        ];
    }
    public function lables():array{
        return[
            'firstname'      =>'First Name',
            'lastname'       =>'Last Name',
            'email'          =>'Email',
            'password'       =>'Password',
            'confirmPassword'=>'Confirm  Password',
       ];
    }

    public function tableName():string{
        return $this->dbTableName;
    }
    public function register(){
        
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'firstname'=>$this->firstname,
            'lastname'=>$this->lastname,
            'email'=>$this->email,
            'password'=> password_hash($this->password,PASSWORD_DEFAULT),
            'created'=>time(),
        ]);
        return $last_id;
    }

}