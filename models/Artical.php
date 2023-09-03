<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
class Artical extends Model{
    public $title='';
    public $is_show=1;
    public $cate_id=0;
    public $content='';
    public $imags=[];
    public $navOption=[];
    public $categories=[];
    /**
     * Database Table Info
     */
    public $dbTableName='artical';

    private $dbColums=['title','is_show','cate_id','content'];
    public function __construct() {
        $this->navOption[1]="Show";
        $this->navOption[0]="Not Show";

        $categoryModel=new Category();
        $categories=$categoryModel->get();
        foreach ($categories as $cat) {
            $this->categories[$cat['id']]=$cat['title'];
        }
    }
    public function rules():array
    {
        return[
             'title'      =>[self::RULE_REQUIERD],
             'is_show'    =>[self::RULE_REQUIERD],
             'cate_id'    =>[self::RULE_REQUIERD],
             'content'    =>[self::RULE_REQUIERD],
             'imags'        =>[self::RULE_REQUIERD,[self::RULE_FILES,'exe'=>['png','jpg']]],
        ];
    }
    public function lables():array{
        return[
            'title'     =>'Artical Title',
            'content'   =>'Artical Content',
            'cate_id'   =>'Category Name',
            'is_show'   =>'Show Artical',
            'imags'    =>'Artical Photo',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){

        $last_id=Application::$app->db->insert($this->tableName(),[
            'title'     =>$this->title,
            'content'   =>$this->content,
            'cate_id'   => $this->cate_id,
            'is_show'   => $this->is_show,
            'created'   =>time(),
        ]);
        $art_Photo=new ArticalPhoto();
        $art_Photo->insert($last_id,$this->imags);
        return $last_id;
    }
    public function update($id){
    }
    public function get(){
        $D=Application::$app->db->query('SELECT `a`.`id`,
        `a`.`cate_id`,
        `a`.`title`,
        `a`.`content`,
        `a`.`is_show`,
        `a`.`deleted`,
        `c`.`name` `cname`,
        `p`.`filename` `photo`
        From '.$this->tableName().' `a`
        inner join `category` `c` on  `a`.`cate_id` =`c`.`id` and `c`.`deleted`=0   
        left join `artical_photo` `p` on  `a`.`id` =`p`.`art_id` and `p`.`deleted`=0 and `p`.`is_main`=1
        '
    );
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `a`.`id`,
        `a`.`cate_id`,
        `a`.`title`,
        `a`.`content`,
        `a`.`is_show`,
        `a`.`deleted`,
        `c`.`name` `cname`,
        `p`.`filename`
        From `'.$this->tableName().'` `a`
        inner join `category` `c` on  `a`.`cate_id` =`c`.`id` and `c`.`deleted`=0   
        left join `artical_photo` `p` on  `a`.`id` =`p`.`art_id` and `p`.`deleted`=0 and `p`.`is_main`=1
        WHERE `a`.`id`=?',[$id]);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->tableName(),['deleted'=>time()],['id'=>$id]);
        return $last_id;
    }
    

}