<?php $form = app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->SelectField($model, 'dars_id', $model->darsOption ?? [], $model->dars_id) ?>
<?php echo $form->SelectField($model, 'grade_id', $model->gradOption ?? [], $model->grade_id) ?>
<?php echo $form->MultiSelectField($model, 'division_id', $model->divisionOption ?? [], $model->division_id ?? []) ?>
<?php echo $form->TextareaField($model, 'task') ?>
<?php echo $form->InputField($model, 'deliver_date')->dateField() ?>
<?php echo $form->RadioField($model, 'is_comment', $model->commentOption ?? [], $model->is_comment) ?>

<br>
<button type="submit" class="btn btn-primary" name="$name">ارسال</button>
<?php echo app\core\form\Form::end(); ?> 