<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/learning/<?=$examType?>/add">
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
        <div class="col col-2">اسم المادة</div>
        <div class="col col-1">اليوم</div>
        <div class="col col-1">الدرس</div>
        <div class="col col-3">وقت البداية</div>
        <div class="col col-3">وقت النهاية</div>
        <div class="col col-2">العمليات</div>
    </li> 
    <?php
    use app\core\Application;
    foreach ($data['data'] as $d): ?>
        <li class="table-row shadow">
            <div class="col col-2" data-label="اسم المادة">
                <?= $d['dname'] ?>
            </div>
            <div class="col col-1" data-label="اليوم">
                <?= $d['day'] ?>
            </div>
            <div class="col col-1" data-label="الدرس">
                <?= $d['lesson'] ?>
            </div>
            <div class="col col-3" data-label="وقت البداية">
                <?= Application::$app->fun->getUTS($d['time_start'],"date_time") ?>
            </div>
            <div class="col col-3" data-label="وقت النهاية">
                <?= Application::$app->fun->getUTS($d['time_end'],"date_time") ?>
            </div>

            <div class="col col-2" data-label="العمليات">
                <div class="men-tools">
                    <div class="tools-content">
                        <a href="/cp/learning/<?=$examType?>/edit/<?= $d['id'] ?>" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                        <?php if ($d['deleted'] == 0): ?>
                            <buttonn onclick="DeleteBtnAlert('/cp/learning/<?=$examType?>/delete/<?= $d['id'] ?>')"
                                class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                        <?php else: ?>
                            <a href="/cp/learning/<?=$examType?>/restore/<?= $d['id'] ?>" class="mx-1 btn btn-sm btn-warning">ارجاع</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?= $data['pagination'] ?>
<br>