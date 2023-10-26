<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
class Category extends Model{
    public $title='';
    public $name='';
    public $img='';
    public $nav=0;
    public $order=0;
    public $navOption=[];
    /**
     * Database Table Info
     */
    public $dbTableName='category';

    private $dbColums=['title','name','img','nav','order'];
    public function __construct() {
        $this->navOption[0]="Not Link";
        $this->navOption[1]="Navbar Link";
    }
    public function rules():array
    {
        return[
             'title'      =>[self::RULE_REQUIERD],
             'name'       =>[self::RULE_REQUIERD,[self::RULE_UNIQUE,'class'=>self::class]],
             'img'        =>[self::RULE_REQUIERD,[self::RULE_FILE,'exe'=>['png','jpg']]],
             'nav'        =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
            'title'     =>'Category Title',
            'name'      =>'Category Name',
            'img'       =>'Category Image',
            'nav'       =>'is Category Navbar',
            'order'     =>'Category Navbar Order',
       ];
    }
    public function tableName():string{
        return $this->dbTableName;
    }
    public function insert(){
        $imageClass=new Image();
        $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'title'=>$this->title,
            'name'=>$this->name,
            'img'=> $filename,
            'nav'=> $this->nav,
            'order'=> $this->order,
            'created'=>time(),
        ]);
        return $last_id;
    }
    public function update($id){
        $filename=$this->getOne($id)['img']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $last_id=Application::$app->db->update($this->dbTableName,[
                'title' => $this->title,
                'name'  => $this->name,
                'img'   => $filename,
                'nav'   => $this->nav,
                'order' => $this->order
            ],
            ['id'=>$id]
        );
        return $last_id;
    }
    public function get(){
        $this->setOrder();
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `id`,`name`,`title`,`img`,`nav`,`order`,`deleted` 
        From '.$this->dbTableName
        .(!empty($this->whr)?' where '.$this->whr:'').
        $_p->getLimit()
        ,$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`name`,`title`,`img`,`nav`,`order`,`deleted` 
        From '.$this->dbTableName.' WHERE `deleted`=0'
        ,$this->params);
        return $D;
    }
    public function getOne($id){
        $D=Application::$app->db->row('SELECT `id`,
        `name`,
        `title`,
        `img`,
        `nav`,
        `order`,
        `deleted` 
        From '.$this->dbTableName.' 
        WHERE `id`=?',[$id]);
        return $D;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        return $last_id;
    }
    public function setOrder(){
        $body=Application::$app->request->getBody();
        if(isset($body['q']) && !empty($body['q'])){
            $this->whr.=' `name` like ?';
            $this->params[]='%'.strip_tags($body['q']).'%';
        }
    }
    

}