<?php
namespace app\core\form;

use app\core\form\CheckedField;
use app\core\form\FileField;
use app\core\form\InputField;
use app\core\form\RadioField;
use app\core\form\SelectField;
use app\core\form\MultiSelectField;
use app\core\form\TextareaField;
use app\core\Model;

class Form {
    public static function begin($action,$method){
        echo sprintf ('<form class="py-3"  action="%s" method="%s" enctype="multipart/form-data" >',$action,$method );
        return new Form();
    }
    public static function end(){
        '</form>';
    }
    public  function  InputField(Model $model ,$attribute ){
        return new InputField($model,$attribute); 
    }
    public  function  TextareaField(Model $model ,$attribute ){
        return new TextareaField($model,$attribute); 
    }
    public  function  SelectField(Model $model ,$attribute,array $options=[],string $selected=''){
        return new SelectField($model,$attribute,$options,$selected); 
    }
    public  function  MultiSelectField(Model $model ,$attribute,array $options=[],array $selected=[]){
        return new MultiSelectField($model,$attribute,$options,$selected); 
    }
    public  function  FileField(Model $model ,$attribute ,$multi=false){
        return new FileField($model,$attribute,$multi); 
    }
    public  function  CheckedField(Model $model ,$attribute,array $options=[],string $selected=''){
        return new CheckedField($model,$attribute,$options,$selected); 
    }
    public  function  RadioField(Model $model ,$attribute,array $options=[],string $selected=''){
        return new RadioField($model,$attribute,$options,$selected); 
    }

    
    

}