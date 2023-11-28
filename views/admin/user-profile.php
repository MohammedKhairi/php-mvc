
<div class="row gutters">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="account-settings">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img class="wp100 mh300" src="/uploads/<?=$model->img?>" >
                        </div>
                        <div class="py-2">
                            <h4 class="user-name"><?=$model->code?></h4>
                            <h6 class="user-email"><?=$model->code?></h6>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 row align-items-center">
            <?php $form=app\core\form\Form::begin('','post'); ?>
            <?php echo $form->inputField($model,'code')?>
            <?php echo $form->InputField($model,'pass')->passwordField();?>
            <?php echo $form->fileField($model,'img')?>
            <button type="submit" class="btn btn-primary" name="$name" >
                ارسال
            </button> 
            <?php echo app\core\form\Form::end();?>

    </div>
</div>

