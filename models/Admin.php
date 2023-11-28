<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Image;

class Admin extends Model{
    public $code='';
    public $email='';
    public $pass='';
    public $lvl='';
    public $img='';
    public array $lvlNav;
    /**
     * Database Table Info
     */
    public $dbTableName='user';

    private $dbColums=['code','pass','lvl','img'];
    public function __construct() {
        $this->lvlNav=["editor"=>"editor","user"=>"user"];
    }
    public function rules():array
    {
        return[
             'code'       =>[self::RULE_REQUIERD],
             'lvl'            =>[self::RULE_REQUIERD],
             'pass'       =>[self::RULE_REQUIERD,[self::RULE_MIN,'min'=>5],[self::RULE_MAX,'max'=>24]],
        ];
    }
    public function lables():array{
        return[
            'code'       =>'اسم المستخدم',
            'pass'       =>'الرمز السري ( اختياري )',
            'img'            =>'الصورة ( اختياري)',
            'lvl'            =>'المستوى',
       ];
    }
    public function get(){
        $this->setOrder();
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `id`,`code`,`pass`,`lvl`,`img`,`deleted` 
        From '.$this->dbTableName
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
            'code'=>$this->code,
            'pass'=> password_hash($this->pass,PASSWORD_DEFAULT),
            'lvl'=>$this->lvl,
            'img'=>$filename,
            'created'=>time(),
        ]);
        $this->setLog('alert','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $filename=$this->getOne($id)['img']??'';
        $password=$this->getOne($id)['pass']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $last_id=Application::$app->db->update($this->dbTableName,[
                'code' => $this->code,
                'img'       => $filename,
                'lvl'       => $this->lvl,
                'pass'  => !empty($this->pass)?$this->pass:$password
            ],
            ['id'=>$id]
        );
        $this->setLog('admin','edit',$id);
        return $last_id;
    }
    public function profile($id){
        $filename=$this->getOne($id)['img']??'';
        $password=$this->getOne($id)['password']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $last_id=Application::$app->db->update($this->dbTableName,[
                'code' => $this->code,
                'img'       => $filename,
                'password'  => !empty($this->pass)?(password_hash($this->pass,PASSWORD_DEFAULT)):$password
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`code`,`pass`,`lvl`,`deleted` 
        From '.$this->dbTableName.' WHERE `deleted`=0'
        ,$this->params);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,`code`,`pass`,`lvl`,`deleted` 
        From '.$this->dbTableName.' 
        WHERE `id`=?',[$id]);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('admin','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('admin','restore',$id);

        return $last_id;
    }
    public function setOrder(){
        $body=Application::$app->request->getBody();
        if(isset($body['q']) && !empty($body['q'])){
            $this->whr.=' `code` like ?';
            $this->params[]='%'.strip_tags($body['q']).'%';
        }
    }


}