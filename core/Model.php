<?php 
namespace app\core;

abstract class Model {

    public const RULE_REQUIERD='requierd';
    public const RULE_Email='email';
    public const RULE_MIN='min';
    public const RULE_MAX='max'; 
    public const RULE_MATCH='match ';   
    public array $errors=[];

    public function loadData($data) {
         foreach ($data as $key => $value) {
             if(property_exists($this,$key ))
                $this->{$key}=$value;
         }
        
    }
    abstract public function rules():array;
    public function validate() {

        foreach ($this->rules() as $attribute => $rules) {
            
            $value=$this->{$attribute};
            foreach ($rules as $rule) {
                 $ruleName=$rule;
                 if(!is_string($ruleName)){
                     $ruleName=$rule[0];
                 }
                 if($ruleName==self::RULE_REQUIERD && !$value){
                     $this->addError($attribute,self::RULE_REQUIERD);
                 }

            }

        }

        return empty($this->errors ); 
        
    }

    public function addError(string $attribute,string $rule){ 
        $message=$this->errorMessage()[$rule]??'';
        $this->errors[$attribute][]= $message;
    }

    public function errorMessage(){
        return[
            self::RULE_REQUIERD=>"This Field is Requierd",
            self::RULE_Email=>"This Field Most be Email",
            self::RULE_MIN=>"Min length of this field most be {min}",
            self::RULE_MAX=>"Max length of this field most be {max}",
            self::RULE_MATCH=>"This Field Most be the same {match}",
        ];
    }
}