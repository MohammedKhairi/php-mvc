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
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']); 
    }
    public function isGet(){
        return $this->getMethod() ==='get';
    }
    public function isPost(){
        return $this->getMethod() ==='post';
    }
    public function getBody () {
        $body=[]; 

        if($this->isGet()){
            foreach ($_GET as $key => $value) {
                $body[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        if($this->isPost()){
            foreach ($_POST as $key => $value) {
                $body[$key]=filter_input(INPUT_POST ,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
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