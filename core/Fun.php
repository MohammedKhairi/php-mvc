<?php 

namespace app\core;
class Fun {
public function OrderdArray($array , $key , $value):array
    {
        $arr=[];
        foreach ($array as $a) {
            $arr[$a[$key]] = $a[$value];
        }
        var_dump($arr);exit;
        return $arr;

    }
}