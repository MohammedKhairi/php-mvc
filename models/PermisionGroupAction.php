<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class PermisionGroupAction extends Model{
    public $group_id='';
    public $action_id ='';
    /**
     * Database Table Info
     */
    public $dbTableName='role_group_action';

    private $dbColums=['group_id','action_id'];
    public function __construct() {
    }
    public function rules():array
    {
        return[
        ];
    }
    public function lables():array{
        return[
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert($group_id,$action_id){
        $this->group_id=$group_id;
        $this->action_id=$action_id;
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'action_id' =>$this->action_id,
            'group_id'  =>$this->group_id
        ]);
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,[
            'action_id' =>$this->action_id,
            'group_id'  =>$this->group_id
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function get($group_id){
        $D=Application::$app->db->query('SELECT `a`.`title` `atitle`,`a`.`id` `aid` From '.$this->tableName().' `ga`
        inner join `role_group` `g` on `ga`.`group_id`=`g`.`id` and `g`.`deleted`=0
        inner join `role_action` `a` on `ga`.`action_id`=`a`.`id` and `a`.`deleted`=0
        where `g`.`id`=?
        '
        ,[$group_id]);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`action_id`,`group_id`
        From '.$this->tableName().' 
        WHERE `id`=?',[$id]);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        return $last_id;
    }
    public function removeByTaskId($group_id){
        Application::$app->db->query("DELETE  FROM " . $this->dbTableName . " WHERE `group_id`=? ",[$group_id]);
        return true;
    }
}