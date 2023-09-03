

<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->SelectField($model,'cate_id',$model->categories??[],$model->cate_id)?>
<?php echo $form->fileField($model,'imags',multi:true)?>
<br>
<?php echo $form->RadioField($model,'is_show',$model->navOption,$model->is_show)?>
<br>
<?php echo $form->TextareaField($model,'content')?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >
    Submit
</button> 
<?php echo app\core\form\Form::end();?>