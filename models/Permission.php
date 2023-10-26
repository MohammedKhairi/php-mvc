<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\PermisionGroup;
use app\models\User;
class Permission extends Model{
    public $user_id='';
    public $group_id='';
    public $program_id='';
    private $program;
    private $user;
    private $group;
    public $userOption=[];
    public $groupOption=[];
    public $programOption=[];
    /**
     * Database Table Info
     */
    public $dbTableName='role_has_permition';

    private $dbColums=['user_id','group_id','program_id'];
    public function __construct() {
        $this->program= new PermisionProgram;
        $this->user= new User;
        $this->group= new PermisionGroup;
        $this->userOption=Application::$app->fun->OrderdArray($this->user->get(),k:'id',v:'username');
        $this->groupOption=Application::$app->fun->OrderdArray($this->group->get(),k:'id',v:'name');
        $this->programOption=Application::$app->fun->OrderdArray($this->program->get(),k:'id',v:'title');
    }
    public function rules():array
    {
        return[
             'user_id'   =>[self::RULE_REQUIERD],
             'program_id'=>[self::RULE_REQUIERD],
             'group_id'  =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'user_id'     =>'Users List',
            'program_id'  =>'Programes List',
            'group_id'    =>'Groups List',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'user_id'=>$this->user_id,
            'program_id'=>$this->program_id,
            'group_id'=>$this->group_id,
            'created'=>time(),
        ]);
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,[
            'user_id'=>$this->user_id,
            'program_id'=>$this->program_id,
            'group_id'=>$this->group_id,
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function get(){
    
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `p`.`id` `pid`,
        `u`.`username` `uname`,
        `o`.`title` `otitle`,
        `g`.`name` `gname`
        From '.$this->tableName().' `p`
        inner join `users` `u` on `p`.`user_id`=`u`.`id` and `u`.`deleted`=0
        inner join `role_program` `o` on `p`.`program_id`=`o`.`id` and `o`.`deleted`=0
        inner join `role_group` `g` on `p`.`group_id`=`g`.`id` and `g`.`deleted`=0
        where `p`.`deleted`=0'.
        $this->whr.
        ' order by `p`.`user_id` asc , `p`.`program_id` asc , `p`.`group_id` asc '.
        $_p->getLimit()
        
        ,$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`user_id`,`program_id`,`group_id`,`deleted`
        From '.$this->tableName().' WHERE `id`=?',[$id]);
        return $D;
    }
    /**
     * Summary of getWithProgram
     * @param mixed $uid
     * @param mixed $pname
     * @param mixed $action
     * @return array
     */
    public function getWithProgram($uid,$pname,$action):array{
        $this->whr.=' AND `u`.`id`=?';
        $this->whr.=' AND `o`.`name`=?';
        $this->whr.=' AND `a`.`name`=?';
        $this->params[]=$uid;
        $this->params[]=$pname;
        $this->params[]=$action; 
        //vd($this->whr);vd($this->params);exit;
        $D=Application::$app->db->query('SELECT `p`.`id` `pid`,`g`.`id` `gid`
        From '.$this->tableName().'`p`
        inner join `users` `u` on `p`.`user_id`=`u`.`id` and `u`.`deleted`=0
        inner join `role_program` `o` on `p`.`program_id`=`o`.`id` and `o`.`deleted`=0
        inner join `role_group` `g` on `p`.`group_id`=`g`.`id` and `g`.`deleted`=0
        inner join `role_group_action` `ga` on `g`.`id`=`ga`.`group_id`
        inner join `role_action` `a` on `ga`.`action_id`=`a`.`id` and `a`.`deleted`=0
        where `p`.`deleted`=0'.$this->whr
        ,$this->params);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        return $last_id;
    }
    

}