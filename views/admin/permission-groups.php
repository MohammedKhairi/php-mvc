
<br>
<div class="d-md-flex justify-content-center">
    <div class="col-8"></div>
    <div class="col-4 d-flex justify-content-end">
        <a class="btn btn-primary" href="/cp/permission/group/add">
            New 
            <i class='icon-plus fp80'></i>
        </a>
    </div> 
</div>
<ul class="responsive-table2 fmedium my-2">
    <li class="table-header">
        <div class="col col-3">Name</div>
        <div class="col col-8">Operation</div>
        <div class="col col-1">Actions</div>
    </li>
    <?php
 foreach ($data as $d):?>
        <li class="table-row border-2 border-bottom">
            <div class="col col-3" data-label="Name"><?=$d['name']?></div>
            <div class="col col-8" data-label="Operation">
            <?php foreach ($d['actions'] as $action):?>
                <div class="badge bg-warning"><?=$action['atitle']?></div>
            <?php endforeach;?>
            </div>
            <div class="col col-1" data-label="Actions">
                <div class="menu-tools">
                    <div class="tools-content">
                        <a href="/cp/permission/group/edit/<?=$d['id']?>" class="mx-1 btn btn-sm btn-primary">Edit</a>
                        <?php if($d['deleted']==0):?>
                        <buttonn onclick="DeleteBtnAlert('/cp/permission/group/delete/<?=$d['id']?>')" class="mx-1 btn btn-sm btn-danger">Delete</buttonn>
                        <?php else:?>
                        <a href="/cp/permission/group/restore/<?=$d['id']?>" class="mx-1 btn btn-sm btn-warning">Restore</a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<br>