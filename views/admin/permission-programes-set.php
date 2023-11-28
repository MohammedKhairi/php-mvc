<?php  
use app\core\Application;
?>
<a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/permission/program">
    <div class="d-flex align-items-center mh40">
        <i class="icon-eye"></i>
        <span class="mx-1">عرض البرامج</span>
    </div>
</a>
<?php $form=app\core\form\Form::begin('','post'); ?>
<?php echo $form->inputField($model,'title')?>
<?php echo $form->inputField($model,'name')?>
<button type="submit" class="btn btn-primary" name="$name" >ارسال</button>
<?php echo app\core\form\Form::end();?> 