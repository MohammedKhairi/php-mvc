<div class="d-flex">
    <div class="col-md-8">
        <?php $form=app\core\form\Form::begin('','POST'); ?>
        <?php echo $form->inputField($model,'title')?>
        <?php echo $form->TextareaField($model,'content')?>
        <?php echo $form->fileField($model,'imags',multi:true)?>
        <br>
        <button type="submit" class="btn btn-primary" name="$name" >
            ارسال
        </button> 
        <?php echo app\core\form\Form::end();?>
    </div>
    <div class="col-md-4">
        <div class="p-2">
            <div class="d-flex flex-column justify-content-center">
                <?php foreach($images as $i):?>
                <div class="my-2 flex-column d-flex justify-content-center align-items-center ">
                    <img src="/uploads/<?=$i['filename']?>" class="w200 mh200">
                    <div class="d-flex flex-row justify-content-center my-2">
                        <buttonn onclick="DeleteBtnAlert('/cp/news/delete/photo/<?=$i['id']?>')" class="mx-1 btn btn-sm btn-danger">حذف الصورة</buttonn>
                        <?php if($i['is_main']):?>
                        <a href="/cp/news/ismain/photo/<?=$i['id']?>/0" class="btn btn-primary">غير رئيسية</a>

                        <?php else:?>
                        <a href="/cp/news/ismain/photo/<?=$i['id']?>/1" class="btn btn-primary">رئيسية</a>

                        <?php endif;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        
    </div>
</div>

