<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Register extends Model{
    public $username='';
    public $email='';
    public $img='';
    public $lvl='user';
    public $password='';
    public $confirmPassword='';
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
             'confirmPassword'=>[self::RULE_REQUIERD,[self::RULE_MATCH,'match'=>'password']],
        ];
    }
    public function lables():array{
        return[
            'username'      =>'Your Name',
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
            'username'=>$this->username,
            'email'=>$this->email,
            'img'=>$this->img,
            'lvl'=>$this->lvl,
            'password'=> password_hash($this->password,PASSWORD_DEFAULT),
            'created'=>time(),
        ]);
        return $last_id;
    }

}