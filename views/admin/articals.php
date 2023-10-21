<?php 
use app\core\Application;

?>
<div class="d-md-flex align-items-center">
    <div class="col-md-6">
        <a class="btn btn-sm btn-secondary"  href="/cp/artical/add">
            <div class="d-flex align-items-center">
                <i class="fs-5 text-light icon-plus mx-1"></i>
                add New
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-end align-items-center">
            <form action="">
                <input type="text" class="form-control" placeholder="Search.....">
            </form>
            <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-secondary dropdown mx-1">
                        <i class="fs-5 text-light icon-attachment"></i>
                        <ul class="dropdown-menu">
                            <a href="#" class="dropdown-item ptr">Pdf</a>
                            <a href="#" class="dropdown-item ptr">Excel</a>
                            <a href="#" class="dropdown-item ptr">Csv</a>
                        </ul>
                    </button>
                    <button class="btn btn-sm btn-secondary order-btn mx-1">
                        <i class="fs-5 text-light icon-list-numbered"></i>
                    </button>
            </div>
          

        </div>
    </div>
</div>

<!-- Order Div -->
<div class="order-bar">
    <div class="rightbar-title d-flex align-items-center  justify-content-between">
        <h5 class="m-0">Order Bar</h5>
        <a href="javascript:void(0);" class="order-close-btn">
            <i class="icon-cancel-circle txt-orange fp140"></i>
        </a>
    </div>
    <div class="p-3">
        <form method="get">
            <label for="title">Tile</label>
            <input type="text" class="form-control mb-1" name="title" id="title">
            <label for="number">Number</label>
            <input type="number" class="form-control mb-1" name="number" id="number">
            <button type="submit" class="btn btn btn-primary btn-sm wp100 my-2">Submit</button>
        </form>
    </div>
</div>
<!-- Order Div -->

<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-4">Title</div>
        <div class="col col-2">Imag</div>
        <div class="col col-2">Category</div>
        <div class="col col-2">IS Show</div>
        <div class="col col-2">Actions</div>
    </li>
    <?php
 foreach ($data as $d):?>
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
                        <a href="" class="mx-1 btn btn-sm btn-success">Show</a>
                        <a href="" class="mx-1 btn btn-sm btn-warning">Hide</a>
                        <buttonn onclick="DeleteBtnAlert('/cp/artical/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<ul class="pagination">
    <li class="page-item"> <a class="page-link" href="?page=1">First</a></li>
    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
    <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
    <li class="page-item active"><a class="page-link " href="?page=3">3</a></li>
    <li class="page-item"><a class="page-link" href="?page=4">4</a></li>
    <li class="page-item"><a class="page-link" href="?page=5">5</a></li>
    <li class="page-item"> <a class="page-link" href="?page=6">Last</a></li>
</ul>
<br>