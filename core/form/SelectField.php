<?php
namespace app\core\form;

use app\core\Model;

class SelectField extends BaseField {
    protected $options=[];
    protected $selected='';

     public function __construct(Model $model,string $attribute,array $options=[],string $selected='') {
        parent::__construct($model,$attribute);
        $this->options=$options;
        $this->selected=$selected;
     }
     public function ReanderInput():string{
      $values='';
      $values.='<option  value="" >قم بالاختيار</option>';
      #
      foreach ($this->options as $key => $value) {
        $values.='<option value="'.$key.'" '.($key==$this->selected ||$value==$this->selected?' selected':'').' >'.$value.'</option>';
      }
      #
      return sprintf('<select  id="%s"  name="%s" class="form-control %s">%s</select>',
        #
        $this->attribute,
        $this->attribute,
        $this->model->hasError($this->attribute)?' error-class':'',
        $values,
        #
      );
     }

}