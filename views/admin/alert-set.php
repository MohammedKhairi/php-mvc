<?php $form = app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->SelectField($model, 'grade_id', $model->gradOption ?? [], $model->grade_id) ?>
<?php echo $form->MultiSelectField($model, 'division_id', $model->divisionOption ?? [], $model->division_id ?? []) ?>
<?php echo $form->TextareaField($model, 'content') ?>
<?php echo $form->fileField($model, 'filename') ?>
<br>
<button type="submit" class="btn btn-primary" name="$name">ارسال</button>
<?php echo app\core\form\Form::end(); ?>