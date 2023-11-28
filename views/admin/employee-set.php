
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->inputField($model,'phone')?>
<?php echo $form->fileField($model,'img')?>
<?php echo $form->inputField($model,'birthday')->dateField()?>
<?php echo $form->inputField($model,'province')?>
<?php echo $form->inputField($model,'address')?>
<?php echo $form->inputField($model,'mothe_rname')?>
<?php echo $form->inputField($model,'idcard')?>
<?php echo $form->inputField($model,'hiring_date')->dateField()?>
<?php echo $form->inputField($model,'direct_date')->dateField()?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 
<?php echo app\core\form\Form::end();?>
