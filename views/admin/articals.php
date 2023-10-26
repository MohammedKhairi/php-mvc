<?php 
use app\core\Application;

?>
<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm bg-c-light mh40 p-0 px-1"  href="/cp/artical/add">
            <div class="d-flex align-items-center mh40" style="height: 100%;">
                <i class="fs-5 icon-plus mx-1"></i>
                <span>add New</span>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <div class="d-md-flex justify-content-end align-items-center">
            <form action="">
                <input type="text" class="form-control" placeholder="Search.....">
            </form>
            <div class="d-flex align-items-center">
                    <button class="btn btn-sm bg-c-light dropdown mx-1 mh40 w40">
                        <i class="fs-5 icon-attachment"></i>
                        <ul class="dropdown-menu boxshadow3">
                            <a href="#" class="dropdown-item ptr py-2">Pdf</a>
                            <a href="/cp/artical/export/excel" class="dropdown-item ptr py-2">Excel</a>
                            <a href="#" class="dropdown-item ptr py-2">Csv</a>
                        </ul>
                    </button>
                    <button class="btn btn-sm bg-c-light order-btn mx-1 mh40 w40">
                        <i class="fs-5 icon-list-numbered"></i>
                    </button>
            </div>
        </div>
    </div>
</div>

<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-4">Title</div>
        <div class="col col-2">Imag</div>
        <div class="col col-2">Category</div>
        <div class="col col-2">IS Show</div>
        <div class="col col-2">Actions</div>
    </li>
    <?php
 foreach ($data['data'] as $d):?>
        <li class="table-row border-2 border-bottom">
            <div class="col col-4" data-label="Title"><?=$d['title']?></div>
            <div class="col col-2" data-label="Imag">
                <img class="w50 mh50" src="/uploads/<?=$d['photo']?>" alt="" srcset="">
            </div>
            <div class="col col-2" data-label="Category"><?=$d['cname']?></div>
            <div class="col col-2" data-label="IS Show"><?=$d['is_show']?></div>
            <div class="col col-2" data-label="Actions">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/artical/edit/<?=$d['id']?>" class="mx-1 btn btn-sm btn-primary">Edit</a>
                        <!-- <a href="" class="mx-1 btn btn-sm btn-success">Show</a>
                        <a href="" class="mx-1 btn btn-sm btn-warning">Hide</a> -->
                        <buttonn onclick="DeleteBtnAlert('/cp/artical/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?=$data['pagination']?>
<br>