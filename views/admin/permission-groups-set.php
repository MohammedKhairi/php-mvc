<?php  
use app\core\Application;
?>
<a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/permission/group">
    <div class="d-flex align-items-center mh40">
        <i class="icon-eye"></i>
        <span class="mx-1">عرض المجموعات</span>
    </div>
</a>

<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->inputField($model,'name')?>
<?php echo $form->SelectField($model, 'program_id', $model->programOption ?? [], $model->program_id ?? '') ?>

<div class="row justify-content-start align-items-center flex-row my-4">
    <?php
    foreach($model->actionNav as $k=> $v):
        echo '<div class="col-md-3">';
        echo '<input type="checkbox" name="action_id[]" 
                id="'.$k.'" '.
                (in_array($v['id'],$model->action_id)?'checked':'').
                ' value="'.$v['id'].'">';
        echo '<label class="form-label px-1" for="'.$k.'">'.$v['title'].'</label>';
        echo '</div>';
    endforeach;
    ?>
</div>

<button type="submit" class="btn btn-primary" name="$name" >ارسال</button>
<?php echo app\core\form\Form::end();?>   