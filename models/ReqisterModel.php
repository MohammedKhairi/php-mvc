<?php

namespace app\models;
use app\core\Model;
class RegisterModel extends Model{
    public $firstname;
    public $lasttname;
    public $emailname;
    public $password;
    public $confirmPassword;

    public function register() {
        
    }

    public function rules():array
    {
        return[
             'firstname'      =>[self::RULE_REQUIERD],
             'lastname'       =>[self::RULE_REQUIERD],
             'email'          =>[self::RULE_REQUIERD,self::RULE_Email],
             'password'       =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>8],[self::RULE_MIN,'min'=>24]],
             'confirmPassword'=>[self::RULE_REQUIERD,[self::RULE_MATCH,'password ']],
        ];
    }
}