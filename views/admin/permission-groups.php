
<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-bg mh40 p-0 px-2" href="/cp/permission/group/add">
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
        <div class="col col-2">العنوان</div>
        <div class="col col-2">الاسم</div>
        <div class="col col-2">البرامج</div>
        <div class="col col-4">العملية</div>
        <div class="col col-2">العمليات</div>
    </li>
    <?php
 foreach ($data as $d):?>
        <li class="table-row shadow">
            <div class="col col-2" data-label="العنوان"><?=$d['title']?></div>
            <div class="col col-2" data-label="الاسم"><?=$d['name']?></div>

            <div class="col col-2" data-label="البرامج">
                <?=$d['ptitle']?>
            </div>

            <div class="col col-4" data-label="العملية">
            <?php foreach ($d['actions'] as $action):?>
                <div class="badge border p-2"><?=$action['atitle']?></div>
            <?php endforeach;?>
            </div>
           
            <div class="col col-2" data-label="العمليات">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/permission/group/edit/<?=$d['id']?>" class="mx-1 btn btn-sm btn-primary">تعديل</a>
                        <?php if($d['deleted']==0):?>
                        <buttonn onclick="DeleteBtnAlert('/cp/permission/group/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">حذف</buttonn>
                        <?php else:?>
                        <a href="/cp/permission/group/restore/<?=$d['id']?>" class="mx-1 btn btn-sm btn-warning">استرجاع</a>
                        <?php endif;?>
                    </div>
                </div> 
            </div>
        </li>
    <?php endforeach;?>
</ul>
<br>