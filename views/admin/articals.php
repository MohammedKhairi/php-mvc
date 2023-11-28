<?php 
use app\core\Application;

?>
<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/news/add">
            <div class="d-flex align-items-center mh40">
                <i class="icon-plus"></i>
                <span class="mx-1">اضافة جديده</span>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <div class="d-md-flex justify-content-end align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-bg mx-1 mh40 mw40">
                    <i class="fs-5 icon-external-link"></i>
                    <ul class="dropdown-menu boxshadow3">
                        <a href="#" class="dropdown-item ptr py-2">Pdf</a>
                        <a href="/cp/grade/artical/export/excel" class="dropdown-item ptr py-2">Excel</a>
                        <a href="#" class="dropdown-item ptr py-2">Csv</a>
                    </ul>
                </button>
                <button class="btn btn-sm btn-bg mx-1 mh40 mw40 order-btn">
                    <i class="fs-5 icon-filter"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-3">عنوان الخبر</div>
        <div class="col col-3">المحتوى</div>
        <div class="col col-2">الصور</div>
        <div class="col col-2">اسم المستخدم</div>
        <div class="col col-2">العمليات</div>
    </li>
    <?php
 foreach ($data['data'] as $d):?>
        <li class="table-row shadow">
            <div class="col col-3" data-label="عنوان الخبر"><?=$d['title']?></div>
            <div class="col col-3" data-label="المحتوى">
                <p class="text-colum-2"><?= $d['content'] ?></p>
            </div>
            <div class="col col-2" data-label="الصور">
                <img class="w50 mh50" src="/uploads/<?=$d['photo']?>" alt="" srcset="">
            </div>
            <div class="col col-2" data-label="اسم المستخدم"><?=$d['ename']?></div>
            <div class="col col-2" data-label="العمليات">
                <div class="men-tools">
                    <div class="tools-content">
                        <a href="/cp/news/edit/<?= $d['id'] ?>" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                        <?php if ($d['deleted'] == 0): ?>
                            <buttonn onclick="DeleteBtnAlert('/cp/news/delete/<?= $d['id'] ?>')"
                                class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                        <?php else: ?>
                            <a href="/cp/news/restore/<?= $d['id'] ?>" class="mx-1 btn btn-sm btn-warning">ارجاع</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?=$data['pagination']?>
<br>