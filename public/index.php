<?php
/**
 * Stop the code if the entry not use browser
 */
if(!isset($_SERVER['HTTP_USER_AGENT']))
    die;
/**
 * define if the serve is local or online
*/
define('is_local', (PHP_OS == 'WINNT' || PHP_OS == 'Darwin'));
/**
 * Start Of the Website
 */
require_once __DIR__.'/../vendor/autoload.php';
use app\core\Application ;
use app\controllers\AuthController;
use app\controllers\SiteController ;
// 
use app\controllers\api\ApiArticalController;
use app\controllers\admin\PermisionActionController;
use app\controllers\admin\PermisionGroupController;
use app\controllers\admin\AdminController ;
use app\controllers\admin\PermisionProgramController;
use app\controllers\admin\UserController;
use app\controllers\admin\ExportController;
use app\controllers\admin\EmployeeController;
use app\controllers\admin\GradeController;
use app\controllers\admin\DivisionController;
use app\controllers\admin\DarsController;
use app\controllers\admin\LearningController;
use app\controllers\admin\ExamController;
use app\controllers\admin\ArticalController;
use app\controllers\admin\StudentController;
use app\controllers\admin\AlertController;
use app\controllers\admin\TaskController;



use app\models\Grade;

/**
 * Gloabal Varible 
 * 
*/
define('Dir', __DIR__);

/**
 * Config 
 */
$config['db']=[
    'dbhost'    =>is_local?'localhost':'',
    'dbn'       =>is_local?'school_db':'',
    'user'      =>is_local?'root':'',
    'password'  =>is_local?'':'',
];
#
$config['cpanel']='cp';
$config['api']='api';
#
if(!is_local){
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}
else{
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL); 
}
/**
 * Define Some static Request
 */
define('is_ajax',(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
/**
 * Country And Timezone
 */
date_default_timezone_set('Asia/Baghdad');

/**
 * Summary of cp
 * @return string
 */
function cp($root="/"){
    global $config;
    return $root.$config['cpanel'];
}
function api($root="/"){
    global $config;
    return $root.$config['api'];
}
//function for show data for programmer
/**
 * Summary of vd
 * @param mixed $v
 * @return void
 */
function vd($v){
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}

#
$app=new Application(dirname(__DIR__),$config);
/**
 * ROUTER 
 */
$app->router->req('',[SiteController::class,'home']);
$app->router->req('/login',[AuthController::class,'login']);
$app->router->req('/logout',[AuthController::class,'logout']);
/**
 * Admin Panel Links
 */
$app->router->req(cp().'/dashboard',[AdminController::class,'get']);
/**
 * Category Pages
 */
$app->router->req(cp().'/user',[UserController::class,'get'],'user.get');
$app->router->req(cp().'/user/add' ,[UserController::class,'add'],'user.add');
$app->router->req(cp().'/user/edit/{id}',[UserController::class,'edit'],'user.edit');
$app->router->req(cp().'/user/delete/{id}',[UserController::class,'delete'],'user.delete');
$app->router->req(cp().'/user/restore/{id}',[UserController::class,'restore'],'user.restore');
$app->router->req(cp().'/user/profile',[UserController::class,'profile'],'user.profile');
/**
 * Employee Pages
 */
$app->router->req(cp().'/employee',[EmployeeController::class,'get'],'employee.get');
$app->router->req(cp().'/employee/add' ,[EmployeeController::class,'add'],'employee.add');
$app->router->req(cp().'/employee/edit/{id}',[EmployeeController::class,'edit'],'employee.edit');
$app->router->req(cp().'/employee/delete/{id}',[EmployeeController::class,'delete'],'employee.delete');
$app->router->req(cp().'/employee/restore/{id}',[EmployeeController::class,'restore'],'employee.restore');
/**
 * Grade Pages
 */
$app->router->req(cp().'/grade',[GradeController::class,'get'],'grade.get');
$app->router->req(cp().'/grade/add' ,[GradeController::class,'add'],'grade.add');
$app->router->req(cp().'/grade/edit/{id}',[GradeController::class,'edit'],'grade.edit');
$app->router->req(cp().'/grade/delete/{id}',[GradeController::class,'delete'],'grade.delete');
$app->router->req(cp().'/grade/restore/{id}',[GradeController::class,'restore'],'grade.restore');
/**
 * Division Pages
 */
$app->router->req(cp().'/grade/division',[DivisionController::class,'get'],'division.get');
$app->router->req(cp().'/grade/division/add' ,[DivisionController::class,'add'],'division.add');
$app->router->req(cp().'/grade/division/edit/{id}',[DivisionController::class,'edit'],'division.edit');
$app->router->req(cp().'/grade/division/delete/{id}',[DivisionController::class,'delete'],'division.delete');
$app->router->req(cp().'/grade/division/restore/{id}',[DivisionController::class,'restore'],'division.restore');
/**
 * Dars Pages
 */
$app->router->req(cp().'/dars',[DarsController::class,'get'],'dars.get');
$app->router->req(cp().'/dars/add' ,[DarsController::class,'add'],'dars.add');
$app->router->req(cp().'/dars/edit/{id}',[DarsController::class,'edit'],'dars.edit');
$app->router->req(cp().'/dars/delete/{id}',[DarsController::class,'delete'],'dars.delete');
$app->router->req(cp().'/dars/restore/{id}',[DarsController::class,'restore'],'dars.restore');
/**
 * week Table Pages
 */
$app->router->req(cp().'/learning/week',[LearningController::class,'get'],'week.get');
$app->router->req(cp().'/learning/week/add' ,[LearningController::class,'add'],'week.add');
$app->router->req(cp().'/learning/week/edit/{id}',[LearningController::class,'edit'],'week.edit');
$app->router->req(cp().'/learning/week/delete/{id}',[LearningController::class,'delete'],'week.delete');
$app->router->req(cp().'/learning/week/restore/{id}',[LearningController::class,'restore'],'week.restore');
/**
 * Exam Table Pages
 */
$app->router->req(cp().'/learning/{exam}',[ExamController::class,'get'],'exam.get');
$app->router->req(cp().'/learning/{exam}/add' ,[ExamController::class,'add'],'exam.add');
$app->router->req(cp().'/learning/{exam}/edit/{id}',[ExamController::class,'edit'],'exam.edit');
$app->router->req(cp().'/learning/{exam}/delete/{id}',[ExamController::class,'delete'],'exam.delete');
$app->router->req(cp().'/learning/{exam}/restore/{id}',[ExamController::class,'restore'],'exam.restore');
/**
 * News Pages
 */
$app->router->req(cp().'/news',[ArticalController::class,'get'],'news.get');
$app->router->req(cp().'/news/add' ,[ArticalController::class,'add'],'news.add');
$app->router->req(cp().'/news/edit/{id}',[ArticalController::class,'edit'],'news.edit');
$app->router->req(cp().'/news/delete/{id}',[ArticalController::class,'delete'],'news.delete');
$app->router->req(cp().'/news/restore/{id}',[ArticalController::class,'restore'],'news.restore');
$app->router->req(cp().'/news/delete/photo/{id}',[ArticalController::class,'delete_photo'],'news.delete_photo');
$app->router->req(cp().'/news/ismain/photo/{id}/{val}',[ArticalController::class,'ismain_photo'],'news.ismain_photo');
/**
 * Employee Pages
 */
$app->router->req(cp().'/student',[StudentController::class,'get'],'student.get');
$app->router->req(cp().'/student/add' ,[StudentController::class,'add'],'student.add');
$app->router->req(cp().'/student/edit/{id}',[StudentController::class,'edit'],'student.edit');
$app->router->req(cp().'/student/delete/{id}',[StudentController::class,'delete'],'student.delete');
$app->router->req(cp().'/student/restore/{id}',[StudentController::class,'restore'],'student.restore');
/**
 * Alert Pages
 */
$app->router->req(cp().'/alert',[AlertController::class,'get'],'alert.get');
$app->router->req(cp().'/alert/add' ,[AlertController::class,'add'],'alert.add');
$app->router->req(cp().'/alert/edit/{id}',[AlertController::class,'edit'],'alert.edit');
$app->router->req(cp().'/alert/delete/{id}',[AlertController::class,'delete'],'alert.delete');
$app->router->req(cp().'/alert/restore/{id}',[AlertController::class,'restore'],'alert.restore');
$app->router->req(cp().'/alert/show/{id}',[AlertController::class,'show'],'alert.show');

/**
 * Alert Pages
 */
$app->router->req(cp().'/task',[TaskController::class,'get'],'task.get');
$app->router->req(cp().'/task/add' ,[TaskController::class,'add'],'task.add');
$app->router->req(cp().'/task/edit/{id}',[TaskController::class,'edit'],'task.edit');
$app->router->req(cp().'/task/delete/{id}',[TaskController::class,'delete'],'task.delete');
$app->router->req(cp().'/task/restore/{id}',[TaskController::class,'restore'],'task.restore');
$app->router->req(cp().'/task/show/{id}',[TaskController::class,'show'],'task.show');
$app->router->req(cp().'/task/solve/{id}',[TaskController::class,'solve'],'task.solve');

/**
 * Permisions Pages
 */
//user Program
$app->router->req(cp().'/permission/program',[PermisionProgramController::class,'get'],'program.get');
$app->router->req(cp().'/permission/program/add' ,[PermisionProgramController::class,'add'],'program.add');
$app->router->req(cp().'/permission/program/edit/{id}',[PermisionProgramController::class,'edit'],'program.edit');
$app->router->req(cp().'/permission/program/delete/{id}',[PermisionProgramController::class,'delete'],'program.delete');
$app->router->req(cp().'/permission/program/restore/{id}',[PermisionProgramController::class,'restore'],'program.restore');
//user Action
$app->router->req(cp().'/permission/action',[PermisionActionController::class,'get'],'action.get');
$app->router->req(cp().'/permission/action/add' ,[PermisionActionController::class,'add'],'action.add');
$app->router->req(cp().'/permission/action/edit/{id}',[PermisionActionController::class,'edit'],'action.edit');
$app->router->req(cp().'/permission/action/delete/{id}',[PermisionActionController::class,'delete'],'action.delete');
$app->router->req(cp().'/permission/action/restore/{id}',[PermisionActionController::class,'restore'],'action.restore');
//user Group
$app->router->req(cp().'/permission/group',[PermisionGroupController::class,'get'],'group.get');
$app->router->req(cp().'/permission/group/add' ,[PermisionGroupController::class,'add'],'group.add');
$app->router->req(cp().'/permission/group/edit/{id}',[PermisionGroupController::class,'edit'],'group.edit');
$app->router->req(cp().'/permission/group/delete/{id}',[PermisionGroupController::class,'delete'],'group.delete');
$app->router->req(cp().'/permission/group/restore/{id}',[PermisionGroupController::class,'restore'],'group.restore');


/**
 * --------API---------
 * all api request
 */
$app->router->req(api().'/artical',[ApiArticalController::class,'get']);
//Run App
$app->run();