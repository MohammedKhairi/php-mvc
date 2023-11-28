
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->SelectField($model,'grade_id',$model->gradOption??[],$model->grade_id)?>
<?php echo $form->SelectField($model,'division_id',$model->divisionOption??[],$model->division_id)?>
<?php echo $form->SelectField($model,'emp_id',$model->empOption??[],$model->emp_id)?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->inputField($model,'num')->numberField()?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 

<?php echo app\core\form\Form::end();?> 