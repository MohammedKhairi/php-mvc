<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->fileField($model,'img')?>
<br>
<?php echo $form->RadioField($model,'nav',$model->navOption,$model->nav)?>
<br>
<?php echo $form->inputField($model,'order')?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >
    Submit
</button>
<?php echo app\core\form\Form::end();?>