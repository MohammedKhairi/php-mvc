<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\models\User;
class Employee extends Model{
    public $user_id='';
    public $name='';
    public $status='';
    public $phone='';
    public $img='';
    public $birthday='';
    public $province='';
    public $address ='';
    public $mothe_rname='';
    public $idcard='';
    public $hiring_date='';
    public $direct_date='';

    /**
     * Database Table Info
     */
    public $dbTableName='employee';

    private $dbColums=['user_id','name','status','phone','img','birthday','province','address','mothe_rname','idcard','hiring_date','direct_date'];

    public function rules():array
    {
        return[
            //  'user_id'      =>[self::RULE_REQUIERD],
             'name'         =>[self::RULE_REQUIERD],
            //  'status'       =>[self::RULE_REQUIERD],
             'phone'        =>[self::RULE_REQUIERD],
             'img'          =>[self::RULE_REQUIERD,[self::RULE_FILE,'exe'=>['png','jpg']]],
             'birthday'     =>[self::RULE_REQUIERD],
             'province'     =>[self::RULE_REQUIERD],
             'address'      =>[self::RULE_REQUIERD],
             'mothe_rname'  =>[self::RULE_REQUIERD],
             'idcard'       =>[self::RULE_REQUIERD],
             'hiring_date'  =>[self::RULE_REQUIERD],
             'direct_date'  =>[self::RULE_REQUIERD],
        ];
    }
    public function lables():array{
        return[
             'name'         =>"الاسم الرباعي",
             'phone'        =>"رقم الهاتف",
             'img'          =>"الصورة الشخصية",
             'birthday'     =>"تاريخ الميلاد",
             'province'     =>"المحافظة",
             'address'      =>"العنوان",
             'mothe_rname'  =>"اسم الام",
             'idcard'       =>"رقم الهوية الشخصية",
             'hiring_date'  =>"تاريخ القبول",
             'direct_date'  =>"تاريخ المباشرة",
       ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `e`.*,`u`.* ,`e`.`id` `eid`
        FROM '.$this->dbTableName.' `e`
        inner join `user` `u` on `e`.`user_id` =`u`.`id`
        WHERE `e`.`deleted`=0'.$_p->getLimit());
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`,`user_id`,`img`,`name` FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }
    public function getOne($user_id){
        $D=Application::$app->db->row('SELECT `id`,`user_id`,`img`,`name` 
        FROM '.$this->dbTableName.' WHERE `deleted`=0 and `user_id`=?',[$user_id]);
        return $D;
    }
    public function getOneById($id){
        $D=Application::$app->db->row('SELECT * FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function insert(){
        //
        $imageClass=new Image();
        $filename=$imageClass->cropResizeUpload($this->img,dst_w:200,dst_h:200);
        $user_model=new User();
        $this->user_id=$user_model->insert('emp');
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'user_id'      =>$this->user_id,
            'name'         =>$this->name,
            'phone'        =>$this->phone,
            'img'          =>$filename,
            'birthday'     =>strtotime($this->birthday),
            'province'     =>$this->province,
            'address'      =>$this->address,
            'mothe_rname'  =>$this->mothe_rname,
            'idcard'       =>$this->idcard,
            'hiring_date'  =>strtotime($this->hiring_date),
            'direct_date'  =>strtotime($this->direct_date),
            'created'      =>time(),
        ]);
        $this->setLog('employee','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $filename=$this->getOneById($id)['img']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $last_id=Application::$app->db->update($this->dbTableName,[
            'name'         =>$this->name,
            'phone'        =>$this->phone,
            'img'          =>$filename,
            'birthday'     =>strtotime($this->birthday),
            'province'     =>$this->province,
            'address'      =>$this->address,
            'mothe_rname'  =>$this->mothe_rname,
            'idcard'       =>$this->idcard,
            'hiring_date'  =>strtotime($this->hiring_date),
            'direct_date'  =>strtotime($this->direct_date),
            ],
            ['id'=>$id]
        );
        $this->setLog('employee','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('employee','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('employee','restore',$id);
        return $last_id;
    }


}