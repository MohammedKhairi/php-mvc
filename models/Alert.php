<?php

namespace app\models;

use app\core\Application;
use app\core\Image;
use app\core\Model;
use app\core\Request;
use app\models\AlertDivision;


class Alert extends Model{
    public $emp_id=0;
    public $grade_id=0;
    public $division_id;
    public $content='';
    public $filename='';

    public $gradOption= '';
    public $divisionOption= '';
    /**
     * Database Table Info
     */
    public $dbTableName='alert';

    private $dbColums=['emp_id','grade_id','division_id','content','filename'];

    public function rules():array
    {
        return[
            //  'emp_id'      =>[self::RULE_REQUIERD],
             'grade_id'     =>[self::RULE_REQUIERD],
             'division_id'  =>[self::RULE_REQUIERD],
             'content'      =>[self::RULE_REQUIERD],
             'filename'     =>[self::RULE_REQUIERD,[self::RULE_FILES,'exe'=>['png','jpg']]],
        ];
    }
    public function lables():array{
        return[
             'grade_id'     =>"الصف",
             'division_id'  =>"الشعبة",
             'content'      =>"المحتوى",
             'filename'     =>"الملف",
        ];
    }
    public function get(){
        $this->sorte();
        #
        $_p=$this->Pagination();
        #
        // vd($this->whr);
        // vd($this->params);
        // exit;
        $D=Application::$app->db->query('SELECT `a`.`content`,
        `a`.`id` `aid`,
        `a`.`filename`,
        `a`.`deleted`,
        (SELECT count(`d`.`name`) FROM `alert_division` `ad`
        inner join `division` `d` on  `ad`.`division_id` =`d`.`id`
        WHERE `alert_id`=`aid`) `dnumber`
        ,
        `g`.`name` `gname`,
        `e`.`name` `ename`
        FROM '.$this->dbTableName.' `a`
        inner join `grade` `g` on `a`.`grade_id` = `g`.`id` 
        inner join `employee` `e` on `a`.`emp_id` = `e`.`id` 
        WHERE `a`.`deleted`=0 '.$this->whr.$_p->getLimit(),$this->params);
        $D['pagination']=$_p->drawPager($D['data_number']);
        return $D;
    }
    public function getAll(){
        $this->sorte();
        #
        $D=Application::$app->db->query('SELECT `a`.`id`,
        `a`.`emp_id`,
        `a`.`grade_id`,
        `a`.`content`,
        `a`.`filename`,
        `a`.`deleted` 
        FROM '.$this->dbTableName.' WHERE `a`.`deleted`=0'.$this->whr,$this->params);
        return $D;
    }
    public function getOne($id){
        $this->sorte();
        #
        $this->params[]=$id;    
        $D=Application::$app->db->row('SELECT  `a`.`id`,
        `a`.`emp_id`,
        `a`.`grade_id`,
        `a`.`content`,
        `a`.`filename`,
        `a`.`deleted` 
        FROM '.$this->dbTableName.' `a` WHERE `a`.`deleted`=0  '.$this->whr.' and `a`.`id`=?',$this->params);
        return $D;
    }
    public function getOneInfo($id){
        $D=Application::$app->db->row('SELECT `a`.`content`,
        `a`.`id` `aid`,
        `a`.`deleted`,
        `g`.`name` `gname`,
        `e`.`name` `ename`
        FROM '.$this->dbTableName.' `a`
        inner join `grade` `g` on `a`.`grade_id` = `g`.`id` 
        inner join `employee` `e` on `a`.`emp_id` = `e`.`id` 
        WHERE `a`.`deleted`=0 and `a`.`id`=? ',[$id]);
        return $D;
    }
    public function insert(){
        //
        $filename='';
        if($this->filename['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->filename,dst_w:1000,dst_h:900);
        }
        $this->emp_id=Application::$app->session->get('user')['id'];
        //
        $last_id=Application::$app->db->insert($this->dbTableName,[
            'emp_id'       =>$this->emp_id,
            'grade_id'      =>$this->grade_id,
            'content'       =>$this->content,
            'filename'      =>$filename,
            'created'       =>time(),
        ]);
        
        if(!empty($last_id) && !empty($this->division_id)){
            $alertDivision=new AlertDivision();
            foreach ($this->division_id as $v) {
                $alertDivision->alert_id=$last_id;
                $alertDivision->division_id=$v;
                $alertDivision->insert();
            }
        }
        $this->setLog('alert','add',$last_id);
        return $last_id;

    }
    public function update($id){  
        $filename=$this->getOne($id)['filename']??'';
        if($this->filename['error'] ===0)
        {
            $imageClass=new Image();
            $filename=$imageClass->cropResizeUpload($this->filename,dst_w:1000,dst_h:900);
        }
        //
        $last_id=Application::$app->db->update($this->dbTableName,[
            'grade_id'      =>$this->grade_id,
            'content'       =>$this->content,
            'filename'      =>$filename,
            ],
            ['id'=>$id]
        );
        //
        if(!empty($id) && !empty($this->division_id)){
            $alertDivision=new AlertDivision();
            $alertDivision->removeByAlertId($id);   
            foreach ($this->division_id as $v) {
                $alertDivision->alert_id=$id;
                $alertDivision->division_id=$v;
                $alertDivision->insert();
            }
        }
        $this->setLog('alert','edit',$id);
        return $last_id;
    }
    public function remove($id){
        if(!$this->isBelong($id))
            return false;
        //
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>time()],['id'=>$id]);
        $this->setLog('alert','edit',$id);
        return $last_id;
    }
    public function restore($id){
        if(!$this->isBelong($id))
            return false;
        //
        $last_id=Application::$app->db->update($this->dbTableName,['deleted'=>0],['id'=>$id]);
        $this->setLog('alert','edit',$id);
        return $last_id;
    }
    public function sorte(){  
        $user=Application::$app->session->get('user');
        if("employee"==$user['lvl']){
            $this->whr.=' and `a`.`emp_id`=? ';
            $this->params[]=$user['id'];
        }
        else if("student"==$user['lvl']){
            $StudentModel=new Student();
            $std=$StudentModel->getOneById($user['user_id']);
            $this->whr.=' and `a`.`grade_id`=? ';
            $this->params[]=$std['grade_id'];
        }
    }
    public function isBelong($id){  
        if($this->getOne($id))
            return true;
        else
            return false;

    }


}