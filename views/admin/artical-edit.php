<div class="d-flex">
    <div class="col-md-8">
        <?php $form=app\core\form\Form::begin('','POST'); ?>
        <?php echo $form->inputField($model,'title')?>
        <?php echo $form->SelectField($model,'cate_id',$model->categories??[],$model->cate_id)?>
        <?php echo $form->fileField($model,'imags',multi:true)?>
        <br>
        <?php echo $form->RadioField($model,'is_show',$model->navOption,$model->is_show)?>
        <br>
        <?php echo $form->TextareaField($model,'content')?>
        <br>
        <button type="submit" class="btn btn-primary" name="update" >
            Submit
        </button> 
        <?php echo app\core\form\Form::end();?>
    </div>
    <div class="col-md-4">
        <div class="p-2">
            <div class="d-flex flex-column justify-content-center">
                <?php foreach($images as $i):?>
                <div class="my-2 c">
                    <img src="/uploads/<?=$i['filename']?>" class="w200 mh200">
                    <div class="d-flex flex-row justify-content-center my-2">
                        <buttonn onclick="DeleteBtnAlert('/cp/artical/delete/photo/<?=$i['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                        <?php if($i['is_main']):?>
                        <a href="/cp/artical/photo/ismain/<?=$i['id']?>/0" class="btn btn-primary">Not Main</a>

                        <?php else:?>
                        <a href="/cp/artical/photo/ismain/<?=$i['id']?>/1" class="btn btn-primary">Main</a>

                        <?php endif;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        
    </div>
</div>

