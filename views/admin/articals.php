<?php 
use app\core\Application;

?>
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