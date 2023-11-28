<a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/grade/division">
    <div class="d-flex align-items-center mh40">
        <i class="icon-eye"></i>
        <span class="mx-1">عرض الشعب</span>
    </div>
</a>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->SelectField($model,'grade_id',$model->gradOption??[],$model->grade_id)?>
<?php echo $form->inputField($model,'name')?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 

<?php echo app\core\form\Form::end();?> 