<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->inputField($model,'name')?>
<button type="submit" class="btn btn-primary" name="$name" >Submit</button>
<?php echo app\core\form\Form::end();?> 