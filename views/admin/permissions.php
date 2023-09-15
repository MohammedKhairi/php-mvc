<br>
<div class="d-md-flex justify-content-center">
    <div class="col-8"></div>
    <div class="col-4 d-flex justify-content-end">
        <a class="btn btn-primary" href="/cp/permission/add">
            New 
            <i class='icon-plus fp80'></i>
        </a>
    </div> 
</div>
<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-3">User Name</div>
        <div class="col col-2">Program Name</div>
        <div class="col col-2">Section Name</div>
        <div class="col col-2">Group Name</div>
        <div class="col col-1">Actions</div>
    </li>
    <?php
 foreach ($data['data'] as $d):?>
        <li class="table-row border-2 border-bottom">
            <div class="col col-3" data-label="User Name"><?=$d['uname']?></div>
            <div class="col col-2" data-label="Program Name"><?=$d['otitle']?></div>
            <div class="col col-2" data-label="Program Name"><?=$d['section']?></div>
            <div class="col col-2" data-label="Group Name"><?=$d['gname']?></div>
            <div class="col col-1" data-label="Actions">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/permission/edit/<?=$d['pid']?>" class="mx-1 btn btn-sm btn-primary">Edit</a>
                        <buttonn onclick="DeleteBtnAlert('/cp/permission/delete/<?=$d['pid']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?=$data['pagination']?>
<br>