<h3>Register Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'firstname');?>
<?php echo $form->inputField($model,'lastname');?>
<?php echo $form->inputField($model,'email')->emailField();?>
<?php echo $form->inputField($model,'password')->passwordField();?>
<?php echo $form->inputField($model,'confirmPassword')->passwordField();?>
<button type="submit" class="btn btn-primary my-2">Submit</button>
<?php echo app\core\form\Form::end();?>