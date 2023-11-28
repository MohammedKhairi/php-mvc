<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\Employee;
class Login extends Model{
    public $code='';
    public $pass='';
    /**
     * Database Table Info
     */
    public $dbTableName='user';

    private $dbColums=['code','pass'];

    public function rules():array
    {
        return[
             'code'          =>[self::RULE_REQUIERD],
             'pass'          =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'code'          =>'رقم المتخدم',
            'pass'          =>'الرمز السري',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function login(){
        $D=Application::$app->db->row('SELECT `id`,`code`,`pass`,`lvl`
            FROM '.$this->dbTableName.' WHERE `code`=?',[$this->code]
        );
        #
        if(empty($D)){
            $this->addError('code','User dose not exist with this Code ');
            return false;
        }
        if($this->pass!=$D['pass']){
            $this->addError('password' ,'Password is Incorrect ');
            return false;
        }
        # student login
        if($D['lvl'] == "student"){
            #
            $student_model=new Student();
            $std=$student_model->getOne($D['id']);
            #
            Application::$app->session->set('user',[
                'id'        =>$std['id'],
                'user_id'   =>$std['user_id'],
                'username'  =>$std['name'],
                'email'     =>$std['name'],
                'img'       =>$std['img'],
                'lvl'       =>$D['lvl'],
            ]);
            #
        }
        #admin , editor ,employee
        else if(in_array($D['lvl'],["admin","editor","employee"])){
            #
            $employee_model=new Employee();
            $emp=$employee_model->getOne($D['id']);
            #
            Application::$app->session->set('user',[
                'id'        =>$emp['id'],
                'user_id'   =>$emp['user_id'],
                'username'  =>$emp['name'],
                'email'     =>$emp['name'],
                'img'       =>$emp['img'],
                'lvl'       =>$D['lvl'],
            ]);
            #
        }
        
        return true;
    }

}