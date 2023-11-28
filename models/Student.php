<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\models\User;
class Student extends Model{
    public $user_id=0;
    public $name='';
    public $last_name='';
    public $gander='';
    public $phone='';
    public $grade_id=0;
    public $division_id=0;
    public $birthday =0;
    public $join_date=0;
    public $installment=0;
    public $discount=0;
    public $registration_num=0;
    public $img='';
    public $address='';
    public $ganderArr=[
        ["key"=>"male"  ,"value"=>"ذكر"],
        ["key"=>"female","value"=>"انثى"]
    ];
    public $ganderOption=[];
    public $gradOption=[];
    public $divisionOption=[];

    /**
     * Database Table Info
     */
    public $dbTableName='student';

    private $dbColums=[
        'user_id',
        'name',
        'last_name',
        'gander',
        'phone',
        'grade_id',
        'division_id',
        'birthday',
        'join_date',
        'installment',
        'discount',
        'img',
        'address'
    ];
    public function __construct() {
        $this->ganderOption = Application::$app->fun->OrderdArray($this->ganderArr,'key','value');
    }

    public function rules():array
    {
        return[
             'name'             =>[self::RULE_REQUIERD],
             'last_name'        =>[self::RULE_REQUIERD],
             'img'              =>[self::RULE_REQUIERD,[self::RULE_FILE,'exe'=>['png','jpg']]],
             'gander'           =>[self::RULE_REQUIERD],
             'registration_num' =>[self::RULE_REQUIERD],
             'phone'            =>[self::RULE_REQUIERD],
             'grade_id'         =>[self::RULE_REQUIERD],
             'division_id'      =>[self::RULE_REQUIERD],
             'birthday'         =>[self::RULE_REQUIERD],
             'join_date'        =>[self::RULE_REQUIERD],
             'installment'      =>[self::RULE_REQUIERD],
             'discount'         =>[self::RULE_REQUIERD],
             'address'          =>[self::RULE_REQUIERD],
             
        ];
    }
    public function lables():array{
        return[
             'name'             =>"الاسم الرباعي",
             'last_name'        =>"اللقب",
             'img'              =>"الصورة الشخصية",
             'gander'           =>"الجنس",
             'registration_num' =>"رقم القيد",
             'phone'            =>"رقم الهاتف",
             'grade_id'         =>"الصف",
             'division_id'      =>"الشعبة",
             'birthday'         =>"تاريخ الميلاد",
             'join_date'        =>"تاريخ الانضمام",
             'installment'      =>"القسط السنوي",
             'discount'         =>"التخفيض",
             'address'          =>"العنوان",
       ];
    }
    public function get(){
        $_p=$this->Pagination();
        $D=Application::$app->db->query('SELECT `s`.*,`u`.* ,`s`.`id` `sid`,`g`.`name` `gname`,`d`.`name` `dname`
        FROM '.$this->dbTableName.' `s`
        inner join `user` `u` on `s`.`user_id` =`u`.`id`
        inner join `grade` `g` on `s`.`grade_id` = `g`.`id` 
        left join `division` `d` on `s`.`division_id` = `d`.`id` 
        WHERE `s`.`deleted`=0'.$_p->getLimit());
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $D=Application::$app->db->query('SELECT `id`, 
        `user_id`, 
        `name`, 
        `last_name`, 
        `gander`, 
        `registration_num`, 
        `phone`, 
        `grade_id`, 
        `division_id`, 
        `birthday`, 
        `join_date`, 
        `installment`, 
        `discount`, 
        `img`, 
        `address`, 
        `deleted`, 
        `is_register` 
        FROM '.$this->dbTableName.' WHERE `deleted`=0');
        return $D;
    }
    public function getOne($user_id){
        $D=Application::$app->db->row('SELECT `id`, 
        `user_id`, 
        `name`, 
        `last_name`, 
        `gander`, 
        `registration_num`, 
        `phone`, 
        `grade_id`, 
        `division_id`, 
        `birthday`, 
        `join_date`, 
        `installment`, 
        `discount`, 
        `img`, 
        `address`, 
        `deleted`, 
        `is_register` 
        FROM '.$this->dbTableName.' WHERE `deleted`=0 and `user_id`=?',[$user_id]);
        return $D;
    }
    public function getOneById($id){
        $D=Application::$app->db->row('SELECT * FROM '.$this->dbTableName.' WHERE `deleted`=0 and `id`=?',[$id]);
        return $D;
    }
    public function insert(){
        //
        // vd($this->division_id);exit;
        $imageClass=new Image();
        $filename=$imageClass->cropResizeUpload($this->img,dst_w:200,dst_h:200);
        $user_model=new User();
        $this->user_id=$user_model->insert('std');
        $this->division_id=empty($this->division_id)?0:$this->division_id;  
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'user_id'          =>$this->user_id,
            'name'             =>$this->name,
            'last_name'        =>$this->last_name,
            'img'              =>$filename,
            'gander'           =>$this->gander,
            'registration_num' =>$this->registration_num,
            'phone'            =>$this->phone,
            'grade_id'         =>$this->grade_id,
            'division_id'      =>$this->division_id??0,
            'birthday'         =>strtotime($this->birthday),
            'join_date'        =>strtotime($this->join_date),
            'installment'      =>$this->installment,
            'discount'         =>$this->discount,
            'address'          =>$this->address,
            'created'          =>time(),
        ]);
        $this->setLog('student','add',$last_id);
        return $last_id;
    }
    public function update($id){
        $filename=$this->getOneById($id)['img']??'';
        if($this->img['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->img,dst_w:600,dst_h:400);
        }
        $this->division_id=empty($this->division_id)?0:$this->division_id;  
        $last_id=Application::$app->db->update($this->dbTableName,[
            'name'             =>$this->name,
            'last_name'        =>$this->last_name,
            'img'              =>$filename,
            'gander'           =>$this->gander,
            'registration_num' =>$this->registration_num,
            'phone'            =>$this->phone,
            'grade_id'         =>$this->grade_id,
            'division_id'      =>$this->division_id,
            'birthday'         =>strtotime($this->birthday),
            'join_date'        =>strtotime($this->join_date),
            'installment'      =>$this->installment,
            'discount'         =>$this->discount,
            'address'          =>$this->address,
            'created'          =>time(),
            ],
            ['id'=>$id]
        );
        $this->setLog('student','edit',$id);
        return $last_id;
    }
    public function remove($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('student','remove',$id);
        return $last_id;
    }
    public function restore($id){
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('student','restore',$id);
        return $last_id;
    }


}