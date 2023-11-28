<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;

class AlertDivision extends Model{
    public $alert_id=0;
    public $division_id=0;
    /**
     * Database Table Info
     */
    public $dbTableName='alert_division';

    private $dbColums=['alert_id','division_id'];

    public function rules():array
    {
        return[
             'alert_id'     =>[self::RULE_REQUIERD],
             'division_id'  =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'alert_id'     =>"التبليغ",
             'division_id'  =>"الشعبة",
        ];
    }
    public function getAllById($id){
        $D=Application::$app->db->query('SELECT `id`,`alert_id`,`division_id` FROM '.$this->dbTableName.' WHERE `id`=?',[$id]);
        return $D;
    }
    public function getAllByAlert($alert_id){
        $D=Application::$app->db->query('SELECT `ad`.`id`,
        `ad`.`alert_id`,
        `ad`.`division_id`,
        `d`.`name` `dname`
        FROM '.$this->dbTableName.' `ad`
        inner join `division` `d` on  `ad`.`division_id` =`d`.`id`
        WHERE `alert_id`=?',[$alert_id]);
        return $D;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'alert_id'      =>$this->alert_id,
            'division_id'   =>$this->division_id,
        ]);
        return $last_id;
    }
    public function removeByAlertId($alert_id){
        Application::$app->db->query("DELETE  FROM " . $this->dbTableName . " WHERE `alert_id`=? ",[$alert_id]);
        return true;
    }
    // public function update($id){  
    //     //
    //     $filename=$this->getOne($id)['filename']??'';
    //     if($this->filename['error'] ===0)
    //     {
    //         $imageClass=new Image();
    //         $filename=$imageClass->cropResizeUpload($this->filename,dst_w:1000,dst_h:900);
    //     }
    //     $this->division_id=empty($this->division_id)?0:$this->division_id;  
    //     //
    //     $last_id=Application::$app->db->update($this->dbTableName,[
    //         'grade_id'      =>$this->grade_id,
    //         'division_id'   =>$this->division_id,
    //         'content'       =>$this->content,
    //         'filename'      =>$filename,
    //         ],
    //         ['id'=>$id]
    //     );

    //     return $last_id;
    // }

}