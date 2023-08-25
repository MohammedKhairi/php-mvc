<?php
namespace app\core\form;

use app\core\form\InputField;
use app\core\Model;

class Form {
    public static function begin($action,$method){
        echo sprintf ('<form  action="%s" method="%s">',$action,$method );
        return new Form();
    }
    public static function end(){
        '</form>';
    }
    public  function  inputField(Model $model ,$attribute ){
        return new InputField($model,$attribute); 
    }
    public  function  TextareaField(Model $model ,$attribute ){
        return new TextareaField($model,$attribute); 
    }
    public  function  SelectField(Model $model ,$attribute,array $options=[],string $selected=''){
        return new SelectField($model,$attribute,$options,$selected); 
    }

}