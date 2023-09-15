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
}
