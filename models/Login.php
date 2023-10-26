<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class Login extends Model{
    public $email='';
    public $password='';
    /**
     * Database Table Info
     */
    public $dbTableName='users';

    private $dbColums=['email','password'];

    public function rules():array
    {
        return[
             'email'          =>[self::RULE_REQUIERD,self::RULE_EMAIL],
             'password'       =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'email'          =>'Email',
            'password'       =>'Password',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function login(){
        $D=Application::$app->db->row('SELECT `id`,`username`,`password`,`email`,`img`,`lvl`
            FROM '.$this->dbTableName.' WHERE `email`=?',[$this->email]
        );
        #
        if(!$D){
            $this->addError('email','User dose not exist with this Email ');
            return false;
        }
        if(!password_verify($this->password,$D['password'])){
            $this->addError('password' ,'Password is Incorrect ');
            return false;
        }
        #
        Application::$app->session->set('user',[
            'id'        =>$D['id'],
            'lvl'       =>$D['lvl'],
            'username'  =>$D['username'],
            'email'     =>$D['email'],
            'img'       =>$D['img'],
        ]);
        #
        return true;
    }

}