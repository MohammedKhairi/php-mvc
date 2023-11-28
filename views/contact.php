<h3>Contact Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->InputField($model,'name')?>
<?php echo $form->InputField($model,'email')->emailField();?>
<?php echo $form->SelectField($model,'dep_id',$departments??[],"2")?>
<?php echo $form->TextareaField($model,'body')?>
<button type="submit">ارسال</button>
<?php echo app\core\form\Form::end();?>