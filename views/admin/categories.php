<?php 
use app\core\Application;
?>

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
        <div class="col col-3">Title</div>
        <div class="col col-2">Name</div>
        <div class="col col-2">Imag</div>
        <div class="col col-2">Nav</div>
        <div class="col col-2">Order</div>
        <div class="col col-1">Actions</div>
    </li>
    <?php
 foreach ($data['data'] as $d):?>
        <li class="table-row border-2 border-bottom">
            <div class="col col-3" data-label="Title"><?=$d['title']?></div>
            <div class="col col-2" data-label="Name"><?=$d['name']?></div>
            <div class="col col-2" data-label="Imag">
                <img class="w50 mh50" src="/uploads/<?=$d['img']?>" alt="" srcset="">
            </div>
            <div class="col col-2" data-label="Nav"><?=$d['nav']?></div>
            <div class="col col-2" data-label="Order"><?=$d['order']?></div>
            <div class="col col-1" data-label="Actions">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/category/edit/<?=$d['id']?>" class="mx-1 btn btn-sm btn-primary">Edit</a>
                        <buttonn onclick="DeleteBtnAlert('/cp/category/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?=$data['pagination']?>
<br>