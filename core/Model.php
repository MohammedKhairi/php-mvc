<?php 
namespace app\core;
use app\core\Pagination;
use app\models\Log;

abstract class Model {

    public const RULE_REQUIERD='requierd';
    public const RULE_EMAIL='email';
    public const RULE_MIN='min';
    public const RULE_MAX='max'; 
    public const RULE_MATCH='match';   
    public const RULE_UNIQUE='unique';   
    public const RULE_FILE='img';   
    public const RULE_FILES='imags';   
    public array $errors=[];
    public $pagination;
    public string $whr='';
    public array $params=[];

    
    public function loadData($data) {
         foreach ($data as $key => $value) {
             if(property_exists($this,$key ))
                $this->{$key}=$value;
         }
        
    }
    public function lables():array {
       return[];  
    }
    public function getLables($attribute){
         return $this->lables()[$attribute]??$attribute; 
    }
    abstract public function rules():array;
    public function validate(array $Without=[]){

        foreach ($this->rules() as $attribute => $rules) {
            
            $value=$this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName=$rule;
                if(!is_string($ruleName)){
                     $ruleName=$rule[0];
                }
                if(!in_array($attribute,$Without)&& $ruleName==self::RULE_REQUIERD){
                    if(is_array($value))
                    {
                        if(empty($value))
                            $this->addErrorForRul($attribute,self::RULE_REQUIERD);
                    }
                    else
                    {
                        if(""===trim($value))
                            $this->addErrorForRul($attribute,self::RULE_REQUIERD);
                    }

                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_EMAIL && ! filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRul($attribute,self::RULE_EMAIL);
                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_MIN && strlen($value)<$rule['min']){
                    $this->addErrorForRul($attribute,self::RULE_MIN,$rule);
                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_MAX && strlen($value)>$rule['max']){
                    $this->addErrorForRul($attribute,self::RULE_MAX,$rule);
                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_MATCH  &&  $value !== $this->{$rule['match']}){
                    $rule['match']=$this->getLables($rule['match']);
                    $this->addErrorForRul($attribute,self::RULE_MATCH ,$rule);
                } 
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_UNIQUE){
                     $className=$rule['class'];
                     $uniqueAttr =$rule['attribute']??$attribute;
                     $tableName=$className::tableName();
                     
                    $usr= Application::$app->db->row("SELECT * From $tableName WHERE $uniqueAttr =? ",[$value]);
                    if($usr){
                        $this->addErrorForRul($attribute,self::RULE_UNIQUE,[ 'field'=>$this->getLables($attribute)]);
                    }
                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_FILE)
                {
                    $image=new Image();
                    $exe=$image->getImageExtension($value['name']);
                    $allowExtension=$rule['exe'];

                    $allowExtensionStr=implode(",",$allowExtension);
                    if(!in_array($exe,$allowExtension)){
                        $this->addErrorForRul($attribute,self::RULE_FILE,['exe'=>$allowExtensionStr]);
                    }

                }
                if(!in_array($attribute,$Without)&&$ruleName==self::RULE_FILES)
                {
                    $image=new Image();
                    foreach ($value['name'] as $v) {
                        $exe=$image->getImageExtension($v);
                        $allowExtension=$rule['exe'];
    
                        $allowExtensionStr=implode(",",$allowExtension);
                        if(!in_array($exe,$allowExtension)){
                            $this->addErrorForRul($attribute,self::RULE_FILE,['exe'=>$allowExtensionStr]);
                            break;
                        }
                    }
                }
            }

        }

        return empty($this->errors); 
        
    }
    private function addErrorForRul(string $attribute,string $rule,$params=[]){ 
        $message=$this->errorMessage()[$rule]??'';

        foreach ($params as $key => $value) {
            $message=str_replace("{{$key}}",$value,$message); 
        }
        $this->errors[$attribute][]= $message;
    }
    public function addError(string $attribute,string $message){ 
        $this->errors[$attribute][]= $message;
    }  
    public function errorMessage(){
        return[
            self::RULE_REQUIERD=>"This Field is Requierd",
            self::RULE_EMAIL=>"This Field Most be Email",
            self::RULE_MIN=>"Min length of this field most be {min}",
            self::RULE_MAX=>"Max length of this field most be {max}",
            self::RULE_MATCH=>"This Field Most be the same {match}",
            self::RULE_UNIQUE=>"Record with this {field} already exits",
            self::RULE_FILE=>"Only File {exe} Excepted",
        ];
    }
    public function hasError($attribute){
         return $this->errors[$attribute]??false; 
    }
    public function getFirstError($attribute){
        return $this->errors[$attribute][0]??false;
    }
    public function Pagination(){
        $this->pagination=new Pagination();
        return  $this->pagination;
    }
    public function setLog($program='',$action='',$post_id=0){
        $LogModel=new Log();
        $user_id=Application::$app->session->get('user')['user_id'];
        $LogModel->insert($user_id,$program,$action,$post_id);
    }
}