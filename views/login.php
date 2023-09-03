<h3>Login  Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->InputField($model,'email')->emailField();?>
<?php echo $form->InputField($model,'password')->passwordField();?>
<button type="submit">Submit</button>
<?php echo app\core\form\Form::end();?>