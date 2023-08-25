<?php
namespace app\core\form;
use app\core\Model;


abstract class BaseField {
    public string $attribute;
    public string $type ;
    public Model $model; 
    public function __construct(Model $model,string $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
     } 
    abstract  public function ReanderInput ():string;
    public function __toString(){
        return sprintf('
           <div class="form-group">
               <label for="%s" class="form-label">%s</label>
                %s
               <div class="invalid-feedback">
                %s
               </div>
           </div>
           ',
           $this->attribute,
           $this->model->getLables($this->attribute),
           $this->ReanderInput(),
           $this->model->getFirstError($this->attribute)

       );
    }


}