<?php
namespace app\core\form;

use app\core\Model;

class TextareaField extends BaseField {

     public function __construct(Model $model,string $attribute) {
        parent::__construct($model,$attribute);
     }
     public function ReanderInput():string{
      return sprintf('<textarea  id="%s"  name="%s" class="form-control %s" rows="10" >%s</textarea>',
        #
        $this->attribute,
        $this->attribute,
        $this->model->hasError($this->attribute)?' error-class':'',
        $this->model->{$this->attribute},
        #
      );
     }

}