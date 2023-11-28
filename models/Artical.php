<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
class Artical extends Model{
    public $title='';
    public $user_id=0;
    public $content='';
    public $imags=[];
    /**
     * Database Table Info
     */
    public $dbTableName='artical';

    private $dbColums=['title','user_id','content'];
    public function rules():array
    {
        return[
             'title'      =>[self::RULE_REQUIERD],
             'content'    =>[self::RULE_REQUIERD],
             'imags'      =>[self::RULE_REQUIERD,[self::RULE_FILES,'exe'=>['png','jpg']]],
        ];
    }
    public function lables():array{
        return[
            'title'     =>'عنوان الخبر',
            'content'   =>'محتوى الخبر',
            'imags'    =>'صور الخبر',
       ];
    } 
    public function insert(){

        $last_id=Application::$app->db->insert($this->dbTableName,[
            'title'     =>$this->title,
            'content'   =>$this->content,
            'user_id'   =>Application::$app->session->get('user')['id'],
            'created'   =>time(),
        ]);
        $art_Photo=new ArticalPhoto();
        $art_Photo->insert($last_id,$this->imags);
        $this->setLog('artical','add',$last_id);
        return $last_id;
    }
    public function update($id){
        Application::$app->db->update($this->dbTableName,[
            'title'     =>$this->title,
            'content'   =>$this->content
        ],['id'=>$id]);
        $art_Photo=new ArticalPhoto();
        $art_Photo->insert($id,$this->imags);
        $this->setLog('artical','edit',$id);
        return $id;
    }
    public function get(){
        $this->setOrder();
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `a`.`id`,
        `a`.`title`,
        `a`.`content`,
        `a`.`deleted`,
        `e`.`name` `ename`,
        `p`.`filename` `photo`
        From '.$this->dbTableName.' `a`
        inner join `user` `u` on  `a`.`user_id` =`u`.`id`
        inner join `employee` `e` on  `u`.`id` =`e`.`user_id`
        left join `artical_file` `p` on  `a`.`id` =`p`.`art_id` and `p`.`deleted`=0 and `p`.`is_main`=1
        '.(!empty($this->whr)?' where '.$this->whr:'').' group by `a`.`id`'
        .$_p->getLimit()
        ,$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `a`.`id`,
        `a`.`title`,
        `a`.`content`,
        `a`.`user_id`,
        `a`.`deleted`,
        `e`.`name` `ename`,
        `p`.`filename`
        From `'.$this->dbTableName.'` `a`
        inner join `user` `u` on  `a`.`user_id` =`u`.`id`
        inner join `employee` `e` on  `u`.`id` =`e`.`user_id`
        left join `artical_file` `p` on  `a`.`id` =`p`.`art_id` and `p`.`deleted`=0 and `p`.`is_main`=1
        WHERE `a`.`id`=?',[$id]);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('artical','remove',$id);
        return $last_id;
    }
    public function setOrder(){
        $body=Application::$app->request->getBody();
        if(isset($body['q']) && !empty($body['q'])){
            $this->whr.=' `a`.`title` like ?';
            $this->params[]='%'.strip_tags($body['q']).'%';
        }
    }
    

}