<h3>Register Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->InputField($model,'firstname');?>
<?php echo $form->InputField($model,'lastname');?>
<?php echo $form->InputField($model,'email')->emailField();?>
<?php echo $form->InputField($model,'password')->passwordField();?>
<?php echo $form->InputField($model,'confirmPassword')->passwordField();?>
<button type="submit">Submit</button>
<?php echo app\core\form\Form::end();?>