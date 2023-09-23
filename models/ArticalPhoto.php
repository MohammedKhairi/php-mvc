<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
class ArticalPhoto extends Model{
    public $filename='';
    public $art_id=0;
    public $is_main=0;
    /**
     * Database Table Info
     */
    public $dbTableName='artical_photo';

    private $dbColums=['filename','art_id','is_main'];
    public function __construct() {
    }
    public function rules():array
    {
        return[
             'filename' =>[self::RULE_REQUIERD],
             'art_id'   =>[self::RULE_REQUIERD],
             'is_main'  =>[self::RULE_REQUIERD],
        ];
    } 
    public function lables():array{
        return[
            'filename'  =>'Artical Photo',
            'art_id'    =>'Artical ID',
            'is_main'   =>'Is Main Photo',
       ];
    }
    public function insert($art_id,$images){
        if(!empty($images)){
            $imageClass=new Image();
            $filenames=$imageClass->devideMultiFiles($images);

            $is_main=$this->getOne($art_id)?0:1;
            foreach ($filenames as $f) {
                $this->filename=$imageClass->cropResizeUpload($f,dst_w:800,dst_h:800);
                Application::$app->db->insert($this->dbTableName,[
                    'filename'  =>$this->filename,
                    'art_id'    =>$art_id,
                    'is_main'   =>$is_main,
                    'created'   =>time(),
                ]);
                $is_main=0;
            }
        
        }
    }
    public function updateMain($id,$v){
        $last_id=Application::$app->db->update($this->dbTableName,['is_main'=>$v],['id'=>$id]);
        return $last_id;
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `p`.`id`,`p`.`filename`,`p`.`is_main`
            From '.$this->dbTableName.' `p`
            innere join `artical` `a` on  `a`.`id` =`p`.`art_id` and `p`.`deleted`=0'
        );
        return $D;
    }
    public function getOne($art_id){
        $D=Application::$app->db->query('SELECT `p`.`id`,`p`.`filename`,`p`.`is_main`
            From '.$this->dbTableName.' `p`
            inner join `artical` `a` on `p`.`art_id` = `a`.`id` and `p`.`deleted`=0
            where `a`.`id`=?
            ',[$art_id]
        );
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        return $last_id;
    }
    

}