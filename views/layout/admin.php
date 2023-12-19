<?php 
use app\core\Application;
use app\models\Log;
/**
 * Application Data
 */
$_session=Application::$app->session;
$_fun=Application::$app->fun;
$_request=Application::$app->request;
$_user=$_session->get('user');
/**
 * Databae Data
 */
$_db=Application::$app->db;
$LogModel=new Log();
$_alert=$LogModel->getAlert($_user['lvl'],$_user['id'],$_user['user_id']);

/**
 * Slider Data
 */
$slideLinks = [
    [
        "title" => "لوحة التحكم",
        "name" => "dashboard",
        "slag" => "/cp/dashboard",
        "permission"=>["admin","editor","student","employee"],
        "icon" => "icon-home",
    ],
    [
        "title" => "الصلاحيات",
        "name" => "permission",
        "slag" => "/cp/permission",
        "permission"=>["admin"],
        "icon" => "icon-bookmark-o",
        "sub" => [
            ["title" => "البرامج", "slag" => "/program"],
            ["title" => "العمليات", "slag" => "/action"],
            ["title" => "المجموعات", "slag" => "/group"],
        ]
    ],
    [
        "title" => "الموظف",
        "name" => "employee",
        "slag" => "/cp/employee",
        "permission"=>["admin","editor"],
        "icon" => "icon-teacher",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "الطالب",
        "name" => "student",
        "slag" => "/cp/student",
        "permission"=>["admin","editor"],
        "icon" => "icon-student-person",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "الصفوف والشعب",
        "name" => "grade",
        "slag" => "/cp/grade",
        "permission"=>["admin","editor"],
        "icon" => "icon-sitemap",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
            ["title" => "الشعب", "slag" => "/division"],
        ]
    ],
    [
        "title" => "المواد الدراسية",
        "name" => "dars",
        "slag" => "/cp/dars",
        "icon" => "icon-seminar",
        "permission"=>["admin","editor"],
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "جداول الدروس",
        "name" => "learning",
        "slag" => "/cp/learning",
        "permission"=>["admin","editor"],
        "icon" => "icon-calendar-o",
        "sub" => [
            ["title" => "المحاضرات الاسبوعية", "slag" => "/week"],
            ["title" => "الامتحانات الشهرية" , "slag" => "/month"],
            ["title" => "الامتحانات النهائية", "slag" => "/final"],
        ]
    ],
    [
        "title" => "المراسلات",
        "name" => "chat",
        "slag" => "/cp/chat",
        "permission"=>["admin","editor","student","employee"],
        "icon" => "icon-comment-o",
    ],
    [
        "title" => "الواجبات",
        "name" => "task",
        "slag" => "/cp/task",
        "permission"=>["admin","editor","student","employee"],
        "icon" => "icon-task",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "الاخبار",
        "name" => "news",
        "slag" => "/cp/news",
        "permission"=>["admin","editor"],
        "icon" => "icon-news",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
    [
        "title" => "التبليغات",
        "name" => "alert",
        "slag" => "/cp/alert",
        "permission"=>["admin","editor","student","employee"],
        "icon" => "icon-alert-square",
        "sub" => [
            ["title" => "استعراض", "slag" => ""],
            ["title" => "اضافة", "slag" => "/add"],
        ]
    ],
];
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/assets/admin/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/admin/css/icon.css" rel="stylesheet">
    <link href="/assets/admin/css/style.css" rel="stylesheet">
    <script src="/assets/admin/js/jquery.js"></script>
    <script src="/assets/admin/js/multiselect-dropdown.js"></script>
    <script src="/assets/admin/js/tost.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
    <title><?= $title ?></title>
</head>

<body theme-mode="" font-typography="Roboto">
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="show">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="javascript:void()" class="brand-logo">
                <i class="icon-bank"></i>
                <h5 class="brand-title">اسم المدرسة</h5>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->


        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <!--  -->
                        <div class="header-left">
                            <div class="input-group search-area right d-lg-inline-flex d-none">
                                <input type="text" class="form-control" placeholder="ابحث هنا ....">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <ul class="navbar-nav header-right main-notification">
                            <li class="nav-item notification_dropdown">
                                <a class="nav-link" id="toggleMode" href="javascript:void()">
                                    <i id="mode-icon"></i>
                                </a>
                            </li>
                            <li class="nav-item notification_dropdown">
                                <a class="nav-link" href="javascript:void(0)">
                                    <i class="icon-comment-o"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="javascript:void()" role="button" data-toggle="dropdown">
                                    <i class="icon-bell-o"></i>
                                    <?php if(!empty($_alert)):?>
                                        <div class="pulse-css"></div>
                                    <?php endif?>
                                </a> 
                                <div class="dropdown-menu-c dropdown_menu_anm1 dropdown-menu-w">
                                    <!-- Admin -->
                                    <?php if("admin"==$_user['lvl'] || "student"==$_user['lvl']):?>
                                        <?php foreach ($_alert['data'] as $a):?>
                                            <a href="/cp/<?=$a['program']?>/show/<?=$a['post_id']?>" class="text-color">
                                                <div class="d-flex align-items-center p-2 border-bottom2">
                                                    <div class="col-4">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <img class="w40 mh40 rounded-circle" src="<?=$_fun->uploads().$a['eimg']?>">
                                                            <small class="text-primary"><?=$a['ename']?></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <p class="text-colum-2">
                                                            <?=$_fun->getProgramName($a['program'])?>
                                                            -
                                                            <?=$_fun->getActionName($a['action'])?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    <!-- Employee -->
                                    <?php if("employee"==$_user['lvl']):?>
                                        <?php foreach ($_alert['data'] as $a):?>
                                            <a href="/cp/<?=$a['post_type']?>/show/<?=$a['post_id']?>" class="text-color">
                                                <div class="d-flex align-items-center p-2 border-bottom2">
                                                    <div class="col-4">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <img class="w40 mh40 rounded-circle" src="<?=$_fun->uploads().$a['simg']?>">
                                                            <small class="text-primary"><?=$a['sname']?></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <p class="text-colum-2">
                                                            <?=$_fun->getProgramName($a['post_type']).' / '.$a['comment']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    <!-- Student -->
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void()" role="button" data-toggle="dropdown">
                                    <img src="<?=$_fun->uploads().$_user['img']?>" width="20" alt="">
                                    <div class="header-info">
                                        <span><?=$_user['username']?></span>
                                        <small>
                                            <?=$_fun->getLevel($_user['lvl'])?>
                                        </small>
                                    </div>
                                </a>
                                <div class="dropdown-menu-c dropdown_menu_anm1">
                                    <a href="/cp/user/profile" class="dropdown-item-c ">
                                        <i class="icon-user"></i>
                                        <span>الملف الشخصي </span>
                                    </a>
                                    <a href="/cp/user/profile" class="dropdown-item-c ">
                                        <i class="icon-lock"></i>
                                        <span>تغيير الرمز السري</span>
                                    </a>
                                    <a href="/logout" class="dropdown-item-c ">
                                        <i class="icon-sign-out "></i>
                                        <span>تسجيل الخروج</span>
                                    </a>

                                </div>
                            </li>
                        </ul>
                        <!--  -->
                    </div>
                </nav>
                <div class="sub-header d-flex align-items-center justify-content-between">
                    <div class="">
                        <h5 class="dashboard_bar"><?=$title?> </h5>
                    </div>
                    <!-- <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" class="btn btn-xs btn-primary light mr-1">يوم</a>
                        <a href="javascript:void(0);" class="btn btn-xs btn-primary light mr-1">شهر</a>
                        <a href="javascript:void(0);" class="btn btn-xs btn-primary light">سنة</a>
                    </div> -->
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="sidebar">
            <div class="sidebar-scroll ps">
                <div class="main-profile">
                    <div class="image-bx">
                        <img src="<?=$_fun->uploads().$_user['img']?>" alt="">
                        <a href="javascript:void(0);">
                            <i class="icon-cog"></i>
                        </a>
                    </div>
                    <h5 class="name"><?=$_user['username']?></h5>
                    <p class="email"><?=$_user['email']?></p>
                </div>
                
                <ul class="metismenu" id="menu">
                    <!--  -->
                    <?php foreach ($slideLinks as $link): ?>
                        <?php if( in_array($_user['lvl'],$link['permission'])): ?>
                        <li class="<?=($_request->getActiveUrl()==$link['name']?'link-active slided':'')?>">
                            <a 
                                <?= (isset($link['sub']) && !empty($link['sub'])
                                    ?("class='has-arrow' href='javascript:void()'")
                                    :("href='".$link['slag']."'"))
                                ?>
                            >
                                <i class="<?= $link['icon'] ?>"></i>
                                <span class="nav-text"><?= $link['title'] ?></span>
                            </a>

                            <?php if (isset($link['sub']) && !empty($link['sub'])): ?>
                            <ul class="dropdown_menu_anm1">
                                <?php foreach ($link['sub'] as $s): ?>
                                <li>
                                    <a 
                                        class="<?=($_request->getActiveUrl2()==($link['slag'] . $s['slag'])?'mm-active':'')?>"  
                                        href="<?= $link['slag'] . $s['slag'] ?>"><?= $s['title'] ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                        </li>
                        <?php endif;?>
                    <?php endforeach; ?>

                    <!--  -->
                </ul>
            </div>
        </div>
        <!--**********************************
            Orderbar
        ***********************************-->

        <div class="order-bar">
            <div class="rightbar-title d-flex align-items-center  justify-content-between">
                <h5 class="m-0">قائمة الفرز</h5>
                <a href="javascript:void(0);" class="order-close-btn">
                    <i class="icon-close1"></i>
                </a>
            </div>
            <div class="p-3">
                <form method="get">
                    <label for="title" class="my-1">العنوان</label>
                    <input type="text" class="form-control mb-1" name="title" id="title">
                    
                    <label for="number" class="my-1">الرقم</label>
                    <input type="number" class="form-control mb-1" name="number" id="number">
                    
                    <button type="button" name="order" class="btn btn btn-primary btn-sm wp100 my-2">فرز</button>
                </form>
            </div>
        </div>
        <!--**********************************
            Orderbar end
        ***********************************-->
        <!--**********************************
            Modal 
        ***********************************-->
        <div class="modal_content"></div>
        <!--**********************************
            Modal end
        ***********************************-->
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="mx-sm-3 mt-4">
                    <!-- Toasts -->
                    <div id="toasts"></div>
                    <div class="demo">

                    <?php if ($_session->getFlash('success')): ?>
                            <?php echo '<script>MsgSuccess("'.$_session->getFlash('success').'")</script>'; ?>
                    <?php endif; ?>
                    <?php if ($_session->getFlash('error')): ?>
                            <?php echo '<script>MsgError("'.$_session->getFlash('error').'")</script>'; ?>
                    <?php endif; ?>
                    <?php if ($_session->getFlash('warring')): ?>
                            <?php echo '<script>MsgWarring("'.$_session->getFlash('warring').'")</script>'; ?>
                    <?php endif; ?>
                    </div>
                    <!-- End Toasts -->
                    <!-- Put Content -->
                    {content}
                    <!-- End Put Content  -->

                    <!--**********************************
                        Footer start
                    ***********************************-->
                    <!-- <div class="footer my-4">
                        <div class="copyright">
                            <p>Copyright © Designed &amp; Developed by <a href="../index.htm" target="_blank"> Mohammed Khairi </a>2023</p>
                        </div>
                    </div> -->
                    <!--**********************************
                        Footer end
                    ***********************************-->
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/admin/js/admin.js"></script>

</body>

</html>