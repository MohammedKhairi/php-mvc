<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
class PermisionProgram extends Model{
    public $title ='';
    public $name ='';
    /**
     * Database Table Info
     */
    public $dbTableName='role_program';

    private $dbColums=['name','title'];
    public function __construct() {
    }
    public function rules():array
    {
        return[
             'title'      =>[self::RULE_REQUIERD],
             'name'       =>[self::RULE_REQUIERD,[self::RULE_UNIQUE,'class'=>self::class]],
        ];
    }
    public function lables():array{
        return[
            'title'     =>'Program Title',
            'name'      =>'Program Name',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'title'     =>$this->title,
            'name'      =>$this->name,
            'created'=>time(),
        ]);
        return $last_id;
    }
    public function update($id){
        $last_id=Application::$app->db->update($this->dbTableName,[
                'title' => $this->title,
                'name'  => $this->name,
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`title`,`deleted` 
        From '.$this->tableName()
        ,$this->params);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,
        `name`,
        `title`,
        `deleted` 
        From '.$this->tableName().' 
        WHERE `id`=?',[$id]);
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