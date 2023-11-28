<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/task/add">
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
                        <a href="/cp/artical/export/excel" class="dropdown-item ptr py-2">Excel</a>
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
        <div class="col col-2">المستخدم</div>
        <div class="col col-1">وقت التسليم</div>
        <div class="col col-2">الصف والشعبة</div>
        <div class="col col-4">المهمة</div>
        <div class="col col-1">حالة التعليقات</div>
        <div class="col col-2">العمليات</div>
    </li>
    <?php
    use app\core\Application;
    foreach ($data['data'] as $d): ?>
        <li class="table-row shadow">
            <div class="col col-2" data-label="المستخدم">
                <?= $d['ename'] ?>
            </div>
            <div class="col col-1" data-label="وقت التسليم">
                <?= Application::$app->fun->getUTS($d['deliver_date']) ?>
            </div>
            <div class="col col-2" data-label="الصف والشعبة">
                <?= $d['gname'] ?>
                <br>
             <span class="text-primary"> عدد الشعب: <?= $d['dnumber']??'' ?></span>  
            </div>
            <div class="col col-4" data-label="المهمة">
                <p class="text-colum-2"><?= $d['task'] ?></p>
            </div>
            <div class="col col-1" data-label="حالة التعليقات">
                <?= $d['is_comment'] ?>
            </div>
            <div class="col col-2" data-label="العمليات">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/task/show/<?= $d['tid'] ?>" class="mx-1 btn btn-sm btn-info">عرض</a>
                        <a href="/cp/task/solve/<?= $d['tid'] ?>" class="mx-1 btn btn-sm btn-info">الحل</a>
                        <a href="/cp/task/edit/<?= $d['tid'] ?>" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                        <?php if ($d['deleted'] == 0): ?>
                            <buttonn onclick="DeleteBtnAlert('/cp/task/delete/<?= $d['tid'] ?>')"
                                class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                        <?php else: ?>
                            <a href="/cp/task/restore/<?= $d['tid'] ?>" class="mx-1 btn btn-sm btn-warning">ارجاع</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?= $data['pagination'] ?>
<br>