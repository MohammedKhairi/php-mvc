<?php
namespace app\core\form;

use app\core\Model;

class Field {
     public const TYPE_TXT='text';
     public const TYPE_PASSWORD='password';
     public const TYPE_EMAIL='email';
     public const TYPE_NUMBER='number';
     public Model $model;
     public string $attribute;
     public string $type ;

     public function __construct(Model $model,string $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TXT;
     }

     public function __toString(){
         return sprintf('
            <div class="form-group">
                <label for="%s" class="form-label">%s</label>
                <input  id="%s"  name="%s" value ="%s" class="form-control %s" type="%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
            ',
            $this->attribute,
            $this->attribute,
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute)?' is-invalid':'',
            $this->type,
            $this->model->getFirstError($this->attribute)

        );
     }
     public function passwordField(){
        $this->type=self::TYPE_PASSWORD;
        return $this; 
     }
     public function emailField(){
        $this->type=self::TYPE_EMAIL;
        return $this; 
     }
     public function numberField(){
      $this->type=self::TYPE_NUMBER;
      return $this; 
   }

}