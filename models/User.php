<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class User extends Model{
    public $firstname='';
    public $lastname='';
    public $email='';
    public $password='';
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
        ];
    }
    public function lables():array{
        return[
            'firstname'      =>'First Name',
            'lastname'       =>'Last Name',
            'email'          =>'Email',
            'password'       =>'Password',
       ];
    }

    public function tableName():string{
        return $this->dbTableName;
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `id`,`firstname`,`lastname`FROM '.$this->tableName().' WHERE `deleted`=0');
        return $D;
    }


}