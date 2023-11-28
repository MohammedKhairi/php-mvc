

<div class="d-flex justify-content-center align-content-center my-2">
    <div class="col-md-8">
        <form method="get">
            <div class="d-flex align-items-center">
                <input type="search" class="form-control" name="q" placeholder="Search here">
                <button class="btn btn-sm bg-c-gray text-white mx-1 btn-search">
                    <i class="icon-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<br> 

<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-2">الاسم</div>
        <div class="col col-2">الصورة</div>
        <div class="col col-2">الايميل</div>
        <div class="col col-2">المستوى</div>
        <div class="col col-1">العمليات</div>
    </li>
    <?php
 foreach ($data['data'] as $d):?>
        <li class="table-row border-2 border-bottom">
            <div class="col col-2" data-label="الاسم"><?=$d['username']?></div>
            <div class="col col-2" data-label="الصورة">
                <img class="w50 mh50" src="/uploads/<?=$d['img']?>">
            </div>
            <div class="col col-2" data-label="الايميل"><?=$d['email']?></div>
            <div class="col col-2" data-label="المستوى"><?=$d['lvl']?></div>
            <div class="col col-1" data-label="العمليات">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/user/edit/<?=$d['id']?>" class="mx-1 btn btn-sm btn-primary">Edit</a>
                        <?php if( $d['deleted']==0):?>
                        <buttonn onclick="DeleteBtnAlert('/cp/user/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                        <?php else:?>
                        <a href="/cp/user/restore/<?=$d['id']?>" class="mx-1 btn btn-sm btn-warning">Restore</a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?=$data['pagination']?>
<br>