<?php
use app\core\Application;

$slideLinks = [
    [
        "title" => "لوحة التحكم",
        "name" => "dashboard",
        "slag" => "/cp/dashboard",
        "icon" => "icon-home3"
    ],
    [
        "title" => "الطلاب",
        "name" => "student",
        "slag" => "/cp/student",
        "icon" => "icon-users",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "الموظفين",
        "name" => "employee",
        "slag" => "/cp/employee",
        "icon" => "icon-user",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "الصلاحيات",
        "name" => "permission",
        "slag" => "/cp/permission",
        "icon" => "icon-strikethrough",
        "sub" => [
            ["title" => "البرامج", "slag" => "/program"],
            ["title" => "العمليات", "slag" => "/action"],
            ["title" => "المجموعات", "slag" => "/group"],
            ["title" => "الصلاحيات", "slag" => ""],

        ]
    ],
];

?>

<!--  -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/admin/css/icon.css?">
    <link rel="stylesheet" href="/assets/admin/css/common.css?">
    <link rel="stylesheet" href="/assets/admin/css/style.css?">
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/assets/admin/js/tost.js"></script>
    <title><?= $title ?></title>
</head>

<body>
    <div class="ds-container">
        <!-- SIDEBAR -->
        <nav class="sidebar">
            <div class="sidebar-content">
                <div class="position-relative d-grid grid-columns-5-1 bg-c-gray px-4">
                    <a href="" class="sidebar-brand  d-block text-sm-center text-white py-3 txt-orange fp125">
                        مدرسة
                    </a>
                    <a href="javascript:void(0);" class="close-sidebar menu-btn-toggler">
                        <i class="icon-cancel-circle txt-orange fp140"></i>
                    </a>
                </div>
                <div class="sidebar-user border-bottom">
                    <div class="d-flex justify-content-center align-content-center">
                        <a href="/cp/user/profile">
                            <div 
                                class="cerculer-img boxshadow1" 
                                style="background-image: url('<?=Application::$app->fun->uploads().Application::$app->session->get('user')['img']?>');">
                            </div>
                        </a>
                    </div>
                    <h6 class="c fmedium my-4"><?=Application::$app->session->get('user')['username']?> </h6>
                </div>
                <ul class="sidebar-nav  py-2">
                <?php foreach ($slideLinks as $link): ?>
            
                    <li class="sidebar-item <?=Application::$app->request->getActiveUrl()==$link['name']?' active slided':''?>">
                        <a  href="<?=(isset($link['sub']) && !empty($link['sub']))?'javascript:void(0);':$link['slag'] ?>" 
                            class="sidebar-link <?=(isset($link['sub']) && !empty($link['sub']))?'sidebar-row':'fp120' ?>">
                            <i  class="<?= $link['icon'] ?> fp120"></i>
                            <?= $link['title'] ?>
                        </a>
                        <?php if (isset($link['sub']) && !empty($link['sub'])): ?>
                            <ul class="sidebar-dropdown" <?=Application::$app->request->getActiveUrl()==$link['name']?'style="display:block;"':''?>>
                                <?php foreach ($link['sub'] as $s): ?>
                                    <li class="sidebar-item-sub">
                                        <a class="sidebar-link" href="<?= $link['slag'] . $s['slag'] ?>"><?= $s['title'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                    
                </ul>
            </div>
        </nav>
        <!--END SIDEBAR -->
        <!-- Page Content -->
        <div class="page-content">
            <div class="page-container">
                <!-- TOPBAR -->
                <div class="topbar d-flex justify-content-between align-items-center">
                    <div class="col-2">
                        <div class="menu-btn menu-btn-toggler">
                            <div class="menu-btn__burger"></div>
                        </div>
                    </div>
                    <div class="col-10">
                        <ul class="d-flex justify-content-end align-items-center mx-3 text-light list-unstyled">
                            <li class="p-2 ptr setting-btn"><i class="fs-5 icon-cog"></i></li>
                            <li class="p-2 ptr dropdown">
                                <i class="fs-5 icon-user"></i>
                                <ul class="dropdown-menu">
                                    <a href="/cp/user/profile" class="dropdown-item ptr"><i class="fs-5 icon-user mx-1"></i>الملف الشخصي</a>
                                    <a href="/logout" class="dropdown-item ptr"><i class="fs-5 icon-switch mx-1"></i>تسجيل الخروج</a>
                                </ul>
                            </li>
                            <li class="p-2 ptr dropdown">
                                <i class="fs-5 icon-notification---Copy"></i>
                                <span class="bedget-content"></span>
                                <ul class="dropdown-menu">
                                    <a href="#" class="dropdown-item ptr">Note</a>
                                </ul>
                            </li>
                            <li class="p-2 ptr"><a href="/" class="txt-white"><i class="fs-5 icon-sphere"></i></a></li>
                            <li class="p-2 ptr"><a href="/logout" class="txt-white"><i class="fs-5 icon-switch"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!--END TOPBAR -->
                <!-- Page Details -->
                <div class="header-nav">
                    <h3 class="header-title text-white"><?=$title?></h3>
                    <ol class="d-flex align-items-center list-unstyled p-0">
                        <li class="page-links">
                            <a class="mx-1" href="/cp/dashboard"><i class="icon-home3"></i></a>
                        </li>
                        <?php
                        $links=Application::$app->request->getUrl();  
                        $links=explode('/',$links);
                        $links=array_filter( $links);
                        $temp='/cp';
                        foreach ($links as $l) {
                        if($l !="cp"){
                        $temp.='/'.$l;

                            echo'<li class="page-links">
                                    <a class=" mx-1" href="'.$temp.'">'.ucfirst($l).'</a>
                                </li>';
                        }
                           
                        }
                         //print_r($links);                    
                        ?>
                    </ol>
                </div>
                <!--End Page Details -->
                <!-- Page Data -->
                <main class="r5">
                    <div class="container-fluid py-6 ">
                        <!--  -->
                        <div id="toasts"></div>
                        <div class="demo">

                        <?php if (Application::$app->session->getFlash('success')): ?>
                                <?php echo '<script>MsgSuccess("'.Application::$app->session->getFlash('success').'")</script>'; ?>
                        <?php endif; ?>
                        <?php if (Application::$app->session->getFlash('error')): ?>
                                <?php echo '<script>MsgError("'.Application::$app->session->getFlash('error').'")</script>'; ?>
                        <?php endif; ?>
                        <?php if (Application::$app->session->getFlash('warring')): ?>
                                <?php echo '<script>MsgWarring("'.Application::$app->session->getFlash('warring').'")</script>'; ?>
                        <?php endif; ?>
                        </div>

                        <!--  -->
                       {content}
                    </div>
                  
                </main>
                <!-- EndPage Data -->
            </div>

        </div>
        <!--END Page Content -->
    </div>
    <!--Setting Bar -->
    <div class="end-bar">
        <div class="rightbar-title d-flex align-items-center  justify-content-between">
            <h5 class="m-0">Setting</h5>
            <a href="javascript:void(0);" class="setting-close-btn">
                <i class="icon-cancel-circle txt-orange fp140"></i>
            </a>
        </div>
        <div class="p-3">
            <div class="alert alert-warning fp90">
              All setting will save in Browser
            </div>
            <!-- Settings -->
            <h6 class="mt-3 fw-bold fmedium">Panal Mode</h6>
            <hr class="mt-1">
            <div class="form-check form-switch mb-1">
                <input class="form-check-input toggle-theme" type="checkbox" value="stander" id="stander">
                <label class="fp80" for="stander">Normal</label>
            </div>
            <div class="form-check form-switch mb-1">
                <input class="form-check-input toggle-theme" type="checkbox" value="dark" id="dark">
                <label class="fp80" for="dark">Dark</label>
            </div>
            <div class="form-check form-switch mb-1">
                <input class="form-check-input toggle-theme" type="checkbox" value="light" id="light">
                <label class="fp80" for="light">Light</label>
            </div>
            <!--  -->
            <h6 class="mt-3 fw-bold fmedium">Sidebar State</h6>
            <hr class="mt-1">
            <div class="form-check form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="open-sidebar">
                <label class="fp80" for="open-sidebar">Open/Close</label>
            </div>
            <!--  -->
            <div class="d-grid mt-4">
                <button class="btn btn-primary" id="resetBtn">Reset Setting</button>
            </div>
        </div>
    </div>
    <!--Setting Bar -->
    <!-- Order Div -->
    <div class="order-bar">
        <div class="rightbar-title d-flex align-items-center  justify-content-between">
            <h5 class="m-0">Order Bar</h5>
            <a href="javascript:void(0);" class="order-close-btn">
                <i class="icon-cancel-circle txt-orange fp140"></i>
            </a>
        </div>
        <div class="p-3">
            <!-- <form method="get">
                <label for="title">Tile</label>
                <input type="text" class="form-control mb-1" name="title" id="title">
                <label for="number">Number</label>
                <input type="number" class="form-control mb-1" name="number" id="number">
                <button type="button" name="order" class="btn btn btn-primary btn-sm wp100 my-2">ارسال</button>
            </form> -->
        </div>
    </div>
    <!-- Order Div -->
    <!-- Modal -->
    <div class="modal_content"></div>
    <!--End Modal -->
    <script src="/assets/admin/js/admin.js"></script>
</body>
 
</html>
