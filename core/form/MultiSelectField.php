<?php
namespace app\core\form;

use app\core\Model;

class MultiSelectField extends BaseField {
    protected $options=[];
    protected $selected='';

     public function __construct(Model $model,string $attribute,array $options=[],array $selected =[]) {
        parent::__construct($model,$attribute);
        $this->options=$options;
        $this->selected=$selected;
     }
     public function ReanderInput():string{
      $values='';
      #
      foreach ($this->options as $key => $value) {
        $values.='<option value="'.$key.'" '.(in_array($key,$this->selected) || in_array($value,$this->selected)?' selected':'').' >'.$value.'</option>';
      }
      #
      return sprintf('<select  id="multi-select"  name="%s[]" multiple multiselect-search=true multiselect-select-all=true  class="form-control %s">%s</select>',
        #
        $this->attribute,
        $this->model->hasError($this->attribute)?' error-class':'',
        $values,
        #
      );
     }

}