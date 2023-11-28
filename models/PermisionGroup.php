<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\PermisionAction;
use app\models\PermisionGroupAction;
use app\models\PermisionGroupProgram;
class PermisionGroup extends Model{ 
    public $name='';
    public $title='';
    public $action_id=[];
    public $program_id=0;
    public $actionNav=[];
    public $actionGroup;
    public $groupAction;
    public $programOption=[];

    /**
     * Database Table Info
     */
    public $dbTableName='role_group';

    private $dbColums=['name','title'];
    public function __construct() {
        $this->actionGroup=new PermisionGroupAction;

        $action=new PermisionAction;
        $this->groupAction=new PermisionGroupAction;
        $this->actionNav = $action->get();
    }
    public function rules():array
    {
        return[
            // 'name'          =>[self::RULE_REQUIERD,[self::RULE_UNIQUE,'class'=>self::class]],
            'name'          =>[self::RULE_REQUIERD],
            'title'         =>[self::RULE_REQUIERD],
            'program_id'    =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'title'         =>'العنوان',
            'name'          =>'الاسم',
            'action_id'     =>'اسم العمليات',
            'program_id'    =>'البرامج',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        //var_dump([$this->action_id]);exit;
        $last_id=Application::$app->db->insert($this->dbTableName,
            [
                'title'     =>$this->title,
                'name'      =>$this->name,
                'program_id'=>$this->program_id,
                'created'=>time()
            ]
        );
        //
        foreach ($this->action_id as $v) {
            $this->groupAction->insert($last_id,$v);
        }
        //
        $this->setLog('permission_group','add',$last_id);
        return $last_id;
    }
    public function update($id){
        Application::$app->db->update($this->dbTableName,
        [
            'title'         => $this->title,
            'name'          => $this->name,
            'program_id'    => $this->program_id,
        ],
        ['id'=>$id]);
        //
        $this->groupAction->removeByTaskId($id);
         foreach ($this->action_id as $v) {
            $this->groupAction->insert($id,$v);
        }
        $this->setLog('permission_group','edit',$id);
        return $id;
    } 
    public function get(){
        $D=Application::$app->db->query('SELECT `g`.`id`,
        `p`.`title` `ptitle`,
        `g`.`name`,
        `g`.`title`,
        `g`.`deleted` 
        From '.$this->dbTableName.' `g`
        inner join `role_program` `p` on `g`.`program_id`=`p`.`id` 
        where `g`.`deleted`=0 and `p`.`deleted`=0
        ',$this->params);
        return $D;
    }
    public function getGroups(){

        $D=$this->get();
        $data=[];
        foreach($D as $d){
            $data[]=[
                "id"=>$d['id'],
                "title"=>$d['title'],
                "name"=>$d['name'],
                "ptitle"=>$d['ptitle'],
                "deleted"=>$d['deleted'],
                "actions"=> $this->actionGroup->get($d['id']),
            ]; 
        }
        return $data;
    }
    public function getGroupActionsById($id){
        return $this->actionGroup->get($id);
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`name`,`title`,`program_id`,`deleted` From '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function getWithProgramAction($lvl,$program,$method){
        $D=Application::$app->db->query('SELECT `g`.`id` `gid`
        From '.$this->dbTableName.' `g`
        inner join `role_program` `p` on `g`.`program_id`=`p`.`id` 
        inner join `role_group_action` `ga` on `g`.`id`=`ga`.`group_id` 
        inner join `role_action` `a` on `ga`.`action_id`=`a`.`id` 
        where `g`.`deleted`=0 
        and `p`.`deleted`=0 
        and `a`.`deleted`=0 
        and `g`.`name`=? 
        and `p`.`name`=? 
        and `a`.`name`=?
        ',[$lvl,$program,$method]);
        // vd($D);exit;
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('permission_group','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('permission_group','restore',$id);
        return $last_id;
    }

}