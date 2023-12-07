<?php 

namespace app\core;
class Fun {
    public function OrderdArray($array , $k , $v):array
    {
        $arr=[];
        foreach ($array as  $a)
            $arr[$a[$k]] = $a[$v];
        //
        return $arr;
    }
    public function ArrayByKey($array ,$k):array
    {
            $arr=[];
            foreach ($array as  $a)
                $arr[] = $a[$k];
            //
            return $arr;
    }
    public function ArrayByValue($array):array
    {
            $arr=[];
            foreach ($array as  $a)
                $arr[$a] = $a;
            //
            return $arr;
    }
    public function assets($v,$is_admin=false):string{
        $val='';
        $a=$is_admin?'/admin':'';
        switch ($v) {
            case 'css':
                $val='/assets'.$a.'/css/';
                break;
            case 'js':
                $val='/assets'.$a.'/js/';
                break;
            case 'img':
                $val='/assets'.$a.'/img/';
                break;
            case 'svg':
                $val='/assets'.$a.'/svg/';
                break;
        }
        return $val;
    }
    public function assetsAdmin($v):string{
        return $this->assets($v,true);
    }
    public function uploads($v=''):string{
        $val='';
        switch ($v) {
            case 'dir':
                $val=Dir.'/uploads/';
                break;
            default:
                $val='/uploads/';
                break;
        }
        return $val;
    }
    public function msg($v):string{
        $translate=Application::$app->translate;
        return $translate[$v]??'';
    }
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    
    }
    function getUTS( $time ,$type="date" ) {
        if($type == 'time')
            return Date("h:i:sa",$time);
        elseif($type == 'date_time')
            return Date("Y-m-d h:i:sa",$time);
        else
            return Date("Y-m-d",$time);
    }
    function getFullUTS( $time  ) {
        return Date("Y-m-d\TH:i",$time);
    }
    function getTableLearning($time) {
        $arr=[
            "week"=>"اسبوعي",
            "month"=>"شهري",
            "final"=>"نهائي",
        ];
        return $arr[$time]??'';
    }
    function getLevel($l) {
        $arr=[
            "admin"=>"مدير النظام",
            "editor"=>"محرر",
            "employee"=>"موظف",
            "student"=>"طالب",
        ];
        return $arr[$l]??'';
    }
    function getActionName($a) {
        $arr=[
            "add"=>"اضافه",
            "edit"=>"تعديل",
            "comment"=>"تعليق",
        ];
        return $arr[$a]??'';
    }
    function getProgramName($p) {
        $arr=[
            "alert"=>"تنبيه",
            "task"=>"مهمة",
            "news"=>"الاخبار",
        ];
        return $arr[$p]??'';
    }

}
