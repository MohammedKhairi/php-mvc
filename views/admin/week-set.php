<a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/learning/week">
    <div class="d-flex align-items-center mh40">
        <i class="icon-eye"></i>
        <span class="mx-1">عرض الجدول الاسبوعي</span>
    </div>
</a>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->SelectField($model,'dars_id',$model->darsOption??[],$model->dars_id)?>
<?php echo $form->SelectField($model,'day',$model->daysOption??[],$model->day)?>
<?php echo $form->SelectField($model,'lesson',$model->lessonsOption??[],$model->lesson)?>
<?php echo $form->inputField($model,'time_start')->datetimeField()?>
<?php echo $form->inputField($model,'time_end')->datetimeField()?>
<br>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button> 

<?php echo app\core\form\Form::end();?> 