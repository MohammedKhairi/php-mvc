
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->inputField($model,'last_name')?>
<?php echo $form->SelectField($model,'grade_id',$model->gradOption??[],$model->grade_id)?>
<?php echo $form->SelectField($model,'division_id',$model->divisionOption??[],$model->division_id)?>
<?php echo $form->SelectField($model,'gander',$model->ganderOption??[],$model->gander)?>
<?php echo $form->inputField($model,'birthday')->dateField()?>
<?php echo $form->inputField($model,'join_date')->dateField()?>
<?php echo $form->inputField($model,'phone')->numberField()?>
<?php echo $form->inputField($model,'installment')->numberField()?>
<?php echo $form->inputField($model,'discount')->numberField()?>
<?php echo $form->fileField($model,'img')?>
<?php echo $form->TextareaField($model,'address')?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 
<?php echo app\core\form\Form::end();?>
