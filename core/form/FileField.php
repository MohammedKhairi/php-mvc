<?php
namespace app\core\form;

use app\core\Model;

class FileField extends BaseField {
     public const TYPE_FIEL='file_extension';
     public const TYPE_Audio='audio/*';
     public const TYPE_VIDEO='video/*';
     public const TYPE_IMAGE='image/*'; 
     public string $type ;
     public string $multi='' ;

     public function __construct(Model $model,string $attribute,bool $multi) {
        $this->type = self::TYPE_IMAGE;
        $this->multi = $multi?' multiple ':'';
        parent::__construct($model,$attribute);
     }

    
     public function audioField(){
        $this->type=self::TYPE_Audio;
        return $this; 
     }
     public function videoField(){
        $this->type=self::TYPE_VIDEO;
        return $this; 
     }
     public function fileField(){
      $this->type=self::TYPE_FIEL;
      return $this; 
     }
     public function ReanderInput():string{
      return sprintf('<input  id="%s"  name="%s"  type="file" class="form-control %s" accept="%s" %s>',
        #
        $this->attribute,
        $this->attribute . (!empty($this->multi)?'[]':''),
       // $this->model->{$this->attribute},
        $this->model->hasError($this->attribute)?' error-class':'',
        $this->type,
        $this->multi,
        #
      );
     }

}