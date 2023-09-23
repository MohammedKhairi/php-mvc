<?php 

namespace app\core;
class Fun {
    public function OrderdArray($array , $k , $v):array
    {
    // var_dump($array);exit;
        $arr=[];
        foreach ($array as  $a) {
            $arr[$a[$k]] = $a[$v];
        }
        //var_dump($arr);exit;
        return $arr;
    }
    public function ArrayByKey($array ,$k):array
    {
        // var_dump($array);exit;
            $arr=[];
            foreach ($array as  $a) {
                $arr[] = $a[$k];
            }
            //var_dump($arr);exit;
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

}
