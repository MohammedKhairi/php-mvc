

<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->TextareaField($model,'content')?>
<?php echo $form->fileField($model,'imags',multi:true)?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >
    ارسال
</button>  
<?php echo app\core\form\Form::end();?>