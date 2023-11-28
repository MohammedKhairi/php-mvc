<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->InputField($model,'code')?>
<?php echo $form->InputField($model,'pass')->passwordField();?>
<button type="submit">ارسال</button>
<?php echo app\core\form\Form::end();?>