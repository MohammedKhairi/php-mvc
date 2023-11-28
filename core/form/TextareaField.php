<?php
namespace app\core\form;

use app\core\Model;

class TextareaField extends BaseField {
 
     public int $row=10 ;
     public function __construct(Model $model,string $attribute) {
        parent::__construct($model,$attribute);
     }
     public function Rows($r){
      $this->row=$r;
      return $this; 
     }
     public function ReanderInput():string{
      return sprintf('<textarea  id="%s"  name="%s" class="form-control %s" rows="%s" >%s</textarea>',
        #
        $this->attribute,
        $this->attribute,
        $this->model->hasError($this->attribute)?' error-class':'',
        $this->row,
        $this->model->{$this->attribute},
        # 
      );
     }

}