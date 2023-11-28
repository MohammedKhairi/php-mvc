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
       <p><?=$data['info']['task']?></p> 
        <hr>
        <?php if($data['info']['is_comment'] == 1):?>
            <?php $form = app\core\form\Form::begin('', 'post');?>
            <?php echo $form->TextareaField($model, 'message')->Rows(5) ?>
            <button type="submit" name="<?=$fname?>" class="btn btn-primary">ارسال</button>
            <?php echo app\core\form\Form::end(); ?> 
        <?php endif;?>

        <h4 class="my-3">عدد التعليقات :<?=count($data['comments'])?></h4>
        <hr>
        <?php foreach ($data['comments'] as $c):?>
        <!-- COMMENT 1 - START -->
        <div class="d-flex align-items-center py-2">
            <a  href="#">
                <img class="w50 h50 rounded-circle" src="<?=Application::$app->fun->uploads().$c['eimg'].$c['simg']?>">
            </a>
            <div class="mx-2">
                <h5 class="text-primary"><?= $c['ename'].$c['sname']?></h5>
                <small><?=Application::$app->fun->getUTS($c['mcreated'],'date_time')?></small>
                <p><?= $c['message']?></p>
            </div>
        </div>
        <hr>
        <!-- COMMENT 1 - END -->
        <?php endforeach?>
    </div>
</section>