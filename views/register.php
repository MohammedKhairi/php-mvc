<h3>Register Page</h3>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->field($model,'firstname');?>
<?php echo $form->field($model,'lastname');?>
<?php echo $form->field($model,'email')->emailField();?>
<?php echo $form->field($model,'password')->passwordField();?>
<?php echo $form->field($model,'confirmPassword')->passwordField();?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php echo app\core\form\Form::end();?>