<?php
namespace app\core\form;

use app\core\Model;

class InputField extends BaseField {
     public const TYPE_TXT='text';
     public const TYPE_PASSWORD='password';
     public const TYPE_EMAIL='email';
     public const TYPE_DATE='date'; 
     public const TYPE_DATE_Time='datetime-local'; 
     public const TYPE_Time='time'; 
     public const TYPE_NUMBER='number'; 
     public string $type ;

     public function __construct(Model $model,string $attribute) {
        $this->type = self::TYPE_TXT;
        parent::__construct($model,$attribute);
     }

    
     public function passwordField(){
        $this->type=self::TYPE_PASSWORD;
        return $this; 
     }
     public function emailField(){
        $this->type=self::TYPE_EMAIL;
        return $this; 
     }
     public function dateField(){
         $this->type=self::TYPE_DATE;
         return $this; 
      }
      public function datetimeField(){
         $this->type=self::TYPE_DATE_Time;
         return $this; 
      }
      public function timeField(){
         $this->type=self::TYPE_Time;
         return $this; 
      }
      
     public function numberField(){
      $this->type=self::TYPE_NUMBER;
      return $this; 
     }
     public function ReanderInput():string{
      return sprintf('<input  id="%s"  name="%s" value="%s" class="form-control %s" type="%s">',
        #
        $this->attribute,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute)?' error-class':'',
        $this->type,
        #
      );
     }

}