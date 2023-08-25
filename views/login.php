<h3>Login  Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'email')->emailField();?>
<?php echo $form->inputField($model,'password')->passwordField();?>
<button type="submit" class="btn btn-primary my-2">Submit</button>
<?php echo app\core\form\Form::end();?>