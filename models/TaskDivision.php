<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;

class TaskDivision extends Model{
    public $task_id=0;
    public $division_id=0;
    /**
     * Database Table Info
     */
    public $dbTableName='task_division';

    private $dbColums=['task_id','division_id'];

    public function rules():array
    {
        return[
             'task_id'     =>[self::RULE_REQUIERD],
             'division_id'  =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'task_id'     =>"المهمة",
             'division_id'  =>"الشعبة",
        ];
    }
    public function getAllById($id){
        $D=Application::$app->db->query('SELECT `id`,`task_id`,`division_id` FROM '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function getAllByTask($task_id){
        $D=Application::$app->db->query('SELECT `ad`.`id`,
        `ad`.`task_id`,
        `ad`.`division_id`,
        `d`.`name` `dname`
        FROM '.$this->dbTableName.' `ad`
        inner join `division` `d` on  `ad`.`division_id` =`d`.`id`
        WHERE `task_id`=?',[$task_id]);
        return $D;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'task_id'      =>$this->task_id,
            'division_id'   =>$this->division_id,
        ]);
        return $last_id;
    }
    public function removeByTaskId($task_id){
        Application::$app->db->query("DELETE  FROM " . $this->dbTableName . " WHERE `task_id`=? ",[$task_id]);
        return true;
    }

}