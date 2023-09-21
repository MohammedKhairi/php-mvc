<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class User extends Model{
    public $username='';
    public $email='';
    public $password='';
    /**
     * Database Table Info
     */
    public $dbTableName='users';

    private $dbColums=['username','email','password'];

    public function rules():array
    {
        return[
             'username'      =>[self::RULE_REQUIERD],
             'email'          =>[self::RULE_REQUIERD,self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>self::class]],
             'password'       =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>5],[self::RULE_MAX,'max'=>24]],
        ];
    }
    public function lables():array{
        return[
            'username'      =>'User Name',
            'email'          =>'Email',
            'password'       =>'Password',
       ];
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `id`,`username` FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }


}