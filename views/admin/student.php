<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/student/add">
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
        <div class="col col-2">الاسم</div>
        <div class="col col-2">الصورة</div>
        <div class="col col-2">الحساب</div>
        <div class="col col-2">الصف والشعبة</div>
        <div class="col col-1">العمليات</div>
    </li>
    <?php
    foreach ($data['data'] as $d): ?>
        <li class="table-row shadow">
            <div class="col col-2" data-label="الاسم">
                <?= $d['name'] ?>
            </div>
            <div class="col col-2" data-label="الصورة">
                <img class="w50 mh50" src="/uploads/<?= $d['img'] ?>">
            </div>
            <div class="col col-2" data-label="الحساب">
                <?= $d['code'] ?>
                <br>
                <?= $d['pass'] ?>
            </div>
            <div class="col col-2" data-label="الصف والشعبة">
                <?= $d['gname'] ?>
                <br>
                <?= $d['dname'] ?>
            </div>
            <div class="col col-1" data-label="العمليات">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/student/edit/<?= $d['sid'] ?>" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                        <?php if ($d['deleted'] == 0): ?>
                            <buttonn onclick="DeleteBtnAlert('/cp/student/delete/<?= $d['sid'] ?>')"
                                class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                        <?php else: ?>
                            <a href="/cp/student/restore/<?= $d['sid'] ?>" class="mx-1 btn btn-sm btn-warning">ارجاع</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?= $data['pagination'] ?>
<br>