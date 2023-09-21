<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Image;

class Admin extends Model{
    public $username='';
    public $email='';
    public $password='';
    public $lvl='';
    public $img='';
    public array $lvlNav;
    /**
     * Database Table Info
     */
    public $dbTableName='users';

    private $dbColums=['userame','email','password','lvl','img'];
    public function __construct() {
        $this->lvlNav=["editor"=>"editor","user"=>"user"];
    }
    public function rules():array
    {
        return[
             'username'      =>[self::RULE_REQUIERD],
             'lvl'            =>[self::RULE_REQUIERD],
             'email'          =>[self::RULE_REQUIERD,self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>self::class]],
             'password'       =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>5],[self::RULE_MAX,'max'=>24]],
        ];
    }
    public function lables():array{
        return[
            'username'       =>'Your Name',
            'email'          =>'Email',
            'password'       =>'Password ( Leave it if you to update it )',
            'img'            =>'User Image ( Leave it if you to update it )',
            'lvl'            =>'User Level',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function get(){
        $this->setOrder();
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `id`,`username`,`email`,`password`,`lvl`,`img`,`deleted` 
        From '.$this->tableName()
        .(!empty($this->whr)?' where '.$this->whr:'').
        $_p->getLimit()
        ,$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function insert(){
        $imageClass=new Image();
        $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'username'=>$this->username,
            'email'=>$this->email,
            'password'=> password_hash($this->password,PASSWORD_DEFAULT),
            'lvl'=>$this->lvl,
            'img'=>$filename,
            'created'=>time(),
        ]);
        return $last_id;
    }
    public function update($id){
        $filename=$this->getOne($id)['img']??'';
        $password=$this->getOne($id)['password']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $last_id=Application::$app->db->update($this->dbTableName,[
                'username' => $this->username,
                'email'     => $this->email,
                'img'       => $filename,
                'lvl'       => $this->lvl,
                'password'  => $this->password??$password
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`username`,`email`,`password`,`lvl`,`img`,`deleted` 
        From '.$this->tableName().' WHERE `deleted`=0'
        ,$this->params);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`username`,`email`,`password`,`lvl`,`img`,`deleted` 
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
    public function setOrder(){
        $body=Application::$app->request->getBody();
        if(isset($body['q']) && !empty($body['q'])){
            $this->whr.=' `username` like ?';
            $this->params[]='%'.strip_tags($body['q']).'%';
        }
    }


}