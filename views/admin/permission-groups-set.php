<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'name')?>
<div class="d-md-flex justify-content-start align-items-center flex-row my-4">
    <?php
    foreach($model->actionNav as $k=> $v):
        echo '<div class="col-md-3">';
        echo '<input type="checkbox" name="action_id[]" id="'.$k.'" value="'.$v['id'].'">';
        echo '<label class="form-label px-1" for="'.$k.'">'.$v['title'].'</label>';
        echo '</div>';
    endforeach;
    ?>
</div>

<button type="submit" class="btn btn-primary" name="$name" >Submit</button>
<?php echo app\core\form\Form::end();?>   