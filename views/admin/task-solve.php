<?php use app\core\Application;?>
<section class="content-item" id="comments">
    <div class="container">
        <div class="container">
            <div class="row align-items-center my-3">
                <!--  -->
                <div class="col-2 p-2 border1">المادة</div>
                <div class="col-10 p-2 border1"><?=$data['info']['mname']?></div>
                <!--  -->
                <!--  -->
                <div class="col-2 p-2 border1">الاستاذ</div>
                <div class="col-10 p-2 border1"><?=$data['info']['ename']?></div>
                <!--  -->
                <!--  -->
                <div class="col-2 p-2 border1">الصف</div>
                <div class="col-10 p-2 border1"><?=$data['info']['gname']?></div>
                <!--  -->
                <!--  -->
                <?php if(!empty($data['division'])):?>
                <div class="col-2 p-2 border1">الشعب</div>
                <div class="col-10 p-2 border1">
                    <?php foreach ($data['division'] as $d) echo $d['dname'].' , '?>
                </div>
                <?php endif;?>
                <!--  -->
                <!--  -->
                <div class="col-2 p-2 border1">وقت التسليم</div>
                <div class="col-10 p-2 border1"><?=Application::$app->fun->getUTS($data['info']['deliver_date'])?></div>
                <!--  -->
            </div>
        </div>

        <h4>المهمة</h4>
        <?=$data['info']['task']?>

        <?php if(
            $data['info']['deliver_date'] <= time() && 
            "student"==Application::$app->session->get('user')['lvl']
        ):?>
            <hr>
            <?php $form = app\core\form\Form::begin('', 'post');?>
            <?php echo $form->TextareaField($model, 'content')->Rows(5) ?>
            <?php echo $form->fileField($model,'filename')?>
            <button type="submit" name="<?=$fname?>" class="btn btn-primary">ارسال</button>
            <?php echo app\core\form\Form::end(); ?> 
        <?php endif;?>
        <hr>
        <h4>الحل المرسل</h4>
        <?php foreach ($data['solve'] as $s):?>
            <div class="d-flex align-items-center py-2">
                <div class=""><img class="w50 h50 rounded-circle" src="<?=Application::$app->fun->uploads().$s['simg']?>"></div> 
                <div class="mx-1"><h6><?=$s['sname']?></h6></div> 
            </div>
            <p class="py-2"><?=$s['content']??''?></p> 
            <?php if($s['filename']):?>
            <img class="" src="<?=Application::$app->fun->uploads().$s['filename']??''?>">
            <?php endif;?>
            <hr>
        <?php endforeach?>

    </div>
</section>