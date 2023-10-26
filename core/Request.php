<?php
namespace app\core;
class Request {
    private array $routeParams =[];
    public function getUrl() {
        
         $path=$_SERVER['REQUEST_URI']??'';
         $postion=strpos($path,'?');

         if(false===$postion){
             return $path;
         }
         $path=substr($path,0,$postion);

        return $path;
    }
    public function getUrlArray() {
        
        $links=explode('/',$this->getUrl());
        $links = array_values(array_filter($links));
       return $links;
   }
    public function getActiveUrl($is_cp=true):string {
        
        $path=$_SERVER['REQUEST_URI']??'';
        $arr=explode('/',$path);
        $a=array_filter($arr);
        $link=$is_cp?$a[2]:$a[1];
        if(str_contains($link,'?')){
           $pos=strpos($link,'?');
           return substr($link,0,$pos);
        }
        #
        return $link;

   }
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']); 
    }
    public function isGet(){
        return $this->getMethod() =='get'?true:false;
    }
    public function isPost(){
        return $this->getMethod() =='post'?true:false;
    }
    public function getBody (){
        $body=[];
        if($this->isGet()==true){
            foreach ($_GET as $key => $value) {
                if(is_array($value))
                    $body[$key]=$value;
                else
                $body[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        if($this->isPost()){
            foreach ($_POST as $key => $value) {
                if(is_array($value))
                    $body[$key]=$value;
                else
                    $body[$key]=filter_input(INPUT_POST ,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        #
        if(isset($_FILES)){
            foreach ($_FILES as $key => $value) {
                $body[$key]=$value;
            }
        }
        #
        return $body;
    }
    public function setRouteParams($params){

        $this->routeParams=$params; 
        return $this; 
    }
    public function getRouteParams(){
        return $this->routeParams; 
    }

}