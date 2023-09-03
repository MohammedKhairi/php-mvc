<?php
namespace app\core\form;

use app\core\Model;

class RadioField extends BaseField {
    protected $options=[];
    protected $selected='';

     public function __construct(Model $model,string $attribute,array $options=[],string $selected='') {
        parent::__construct($model,$attribute);
        $this->options=$options;
        $this->selected=$selected;
     }
     public function ReanderInput():string{
      $values='';
      #
      foreach ($this->options as $key => $value) {
        $values.='
        <label class="form-lable">
          <input  
            type="radio" 
            id="'.$key.'"  
            name="'.$this->attribute.'"
            value="'.$key.'"
            '.($key==$this->selected ||$value==$this->selected?' checked':'').'
            class="'.($this->model->hasError($this->attribute)?' error-class':'').'"
          >
          <span>'.$value.' </span>
        </label>
        ';
      }
      #
      return sprintf('<div>%s</div>',$values);
     }

}