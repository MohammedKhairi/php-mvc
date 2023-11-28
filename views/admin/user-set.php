<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'username')?>
<?php echo $form->InputField($model,'email')->emailField();?>
<?php echo $form->InputField($model,'password')->passwordField();?>
<?php echo $form->SelectField($model,'lvl',$model->lvlNav??[],$model->lvl)?>
<?php echo $form->fileField($model,'img')?>
<button type="submit" class="btn btn-primary" name="$name" >
    ارسال
</button> 
<?php echo app\core\form\Form::end();?>