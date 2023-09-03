<?php 
use app\core\Application;

?>
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
 foreach ($data as $d):?>
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
                        <a href="" class="mx-1 btn btn-sm btn-success">Show</a>
                        <a href="" class="mx-1 btn btn-sm btn-warning">Hide</a>
                        <buttonn onclick="DeleteBtnAlert('/cp/category/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
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