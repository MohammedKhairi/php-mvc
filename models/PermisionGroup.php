<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\PermisionAction;
use app\models\PermisionGroupAction;
class PermisionGroup extends Model{
    public $name='';
    public $action_id=[];
    public $actionNav=[];
    public $actionGroup;
    /**
     * Database Table Info
     */
    public $dbTableName='role_group';

    private $dbColums=['name'];
    public function __construct() {
        $this->actionGroup=new PermisionGroupAction;
        $action=new PermisionAction;
        $this->actionNav = $action->get();
    }
    public function rules():array
    {
        return[
            'name'          =>[self::RULE_REQUIERD,[self::RULE_UNIQUE,'class'=>self::class]],
            //'action_id[]'     =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'name'         =>'Group Name',
            'action_id'     =>'Action List',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        //var_dump([$this->action_id]);exit;
        $last_id=Application::$app->db->insert($this->dbTableName,['name'=>$this->name,'created'=>time()]);
        $groupAction=new PermisionGroupAction;
        foreach ($this->action_id as $v) {
            $groupAction->insert($last_id,$v);
        }
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,['name' => $this->name],['id'=>$id]);
       //$this->groupAction->update($last_id);
        return $last_id;
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`deleted` From '.$this->tableName(),$this->params);
        return $D;
    }
    public function getGroupAction(){
        $D=$this->get();
        $data=[];
        foreach($D as $d){
            $data[]=[
                "id"=>$d['id'],
                "name"=>$d['name'],
                "deleted"=>$d['deleted'],
                "actions"=> $this->actionGroup->get($d['id']),
            ];
        }
        return $data;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`name`,`deleted` From '.$this->tableName().' WHERE `id`=?',[$id]);
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