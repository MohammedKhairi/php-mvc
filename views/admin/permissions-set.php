<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->SelectField($model,'user_id',$model->userOption??[],$model->user_id)?>
<?php echo $form->SelectField($model,'program_id',$model->programOption??[],$model->program_id)?>
<?php echo $form->SelectField($model,'group_id',$model->groupOption??[],$model->group_id)?>
<button type="submit" class="btn btn-primary" name="$name" >
    Submit
</button>
<?php echo app\core\form\Form::end();?> 