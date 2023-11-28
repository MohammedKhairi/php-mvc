
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->inputField($model,'less_age')->numberField()?>
<?php echo $form->inputField($model,'oldest_age')->numberField()?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 

<?php echo app\core\form\Form::end();?>