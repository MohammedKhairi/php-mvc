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

use app\controllers\api\ApiArticalController;
use app\controllers\admin\PermisionActionController;
use app\controllers\admin\PermisionGroupController;
use app\controllers\AuthController;
use app\core\Application ;
use app\controllers\SiteController ;
use app\controllers\admin\AdminController ;
use app\controllers\admin\ArticalController;
use app\controllers\admin\CategoryController;
use app\controllers\admin\PermisionProgramController;
use app\controllers\admin\PermissionController;
use app\controllers\admin\UserController;
use app\controllers\admin\ExportController;

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
    'dbn'       =>is_local?'mvc_db':'',
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
$app->router->get('/',[SiteController::class,'home']);

$app->router->get('/contact/{depid}/{id2}',[SiteController::class,'contact']);
$app->router->post('/contact',[SiteController::class,'contact']);

$app->router->req('/login',[AuthController::class,'login']);
$app->router->req('/register',[AuthController::class,'register']);
$app->router->get('/profile',[AuthController::class,'profile']);
$app->router->get('/logout',[AuthController::class,'logout']);
/**
 * Admin Panel Links
 */
$app->router->get(cp().'/dashboard',[AdminController::class,'get']);
/**
 * Category Pages
 */
$app->router->get(cp().'/category',[CategoryController::class,'get'],'category.get');
$app->router->req(cp().'/category/add' ,[CategoryController::class,'add'],'category.add');
$app->router->req(cp().'/category/edit/{id}',[CategoryController::class,'edit'],'category.edit');
$app->router->get(cp().'/category/delete/{id}',[CategoryController::class,'delete'],'category.delete');
/**
 * Category Pages
 */
$app->router->get(cp().'/user',[UserController::class,'get'],'user.get');
$app->router->req(cp().'/user/add' ,[UserController::class,'add'],'user.add');
$app->router->req(cp().'/user/edit/{id}',[UserController::class,'edit'],'user.edit');
$app->router->get(cp().'/user/delete/{id}',[UserController::class,'delete'],'user.delete');
$app->router->get(cp().'/user/restore/{id}',[UserController::class,'restore'],'user.restore');
/**
 * Artical Pages
 */
$app->router->get(cp().'/artical',[ArticalController::class,'get'],'artical.get');
$app->router->req(cp().'/artical/add' ,[ArticalController::class,'add'],'artical.add');
$app->router->req(cp().'/artical/edit/{id}',[ArticalController::class,'edit'],'artical.edit');
$app->router->get(cp().'/artical/delete/{id}',[ArticalController::class,'delete'],'artical.delete');
$app->router->get(cp().'/artical/delete/photo/{id}',[ArticalController::class,'delete_photo'],'artical.delete');
$app->router->get(cp().'/artical/photo/ismain/{id}/{val}',[ArticalController::class,'ismain_photo'],'artical.ismain');

$app->router->get(cp().'/artical/export/excel',[ExportController::class,'artical_excel']);

/**
 * Permisions Pages
 */
//user Program
$app->router->get(cp().'/permission/program',[PermisionProgramController::class,'get'],'program.get');
$app->router->req(cp().'/permission/program/add' ,[PermisionProgramController::class,'add'],'program.add');
$app->router->req(cp().'/permission/program/edit/{id}',[PermisionProgramController::class,'edit'],'program.edit');
$app->router->get(cp().'/permission/program/delete/{id}',[PermisionProgramController::class,'delete'],'program.delete');
$app->router->get(cp().'/permission/program/restore/{id}',[PermisionProgramController::class,'restore'],'program.restore');
//user Action
$app->router->get(cp().'/permission/action',[PermisionActionController::class,'get'],'action.get');
$app->router->req(cp().'/permission/action/add' ,[PermisionActionController::class,'add'],'action.add');
$app->router->req(cp().'/permission/action/edit/{id}',[PermisionActionController::class,'edit'],'action.edit');
$app->router->get(cp().'/permission/action/delete/{id}',[PermisionActionController::class,'delete'],'action.delete');
$app->router->get(cp().'/permission/action/restore/{id}',[PermisionActionController::class,'restore'],'action.restore');
//user Group
$app->router->get(cp().'/permission/group',[PermisionGroupController::class,'get'],'group.get');
$app->router->req(cp().'/permission/group/add' ,[PermisionGroupController::class,'add'],'group.add');
$app->router->req(cp().'/permission/group/edit/{id}',[PermisionGroupController::class,'edit'],'group.edit');
$app->router->get(cp().'/permission/group/delete/{id}',[PermisionGroupController::class,'delete'],'group.delete');
$app->router->get(cp().'/permission/group/restore/{id}',[PermisionGroupController::class,'restore'],'group.restore');

//user Permission
$app->router->get(cp().'/permission',[PermissionController::class,'get'],'permission.get');
$app->router->req(cp().'/permission/add',[PermissionController::class,'add'],'permission.add');
$app->router->req(cp().'/permission/edit/{id}',[PermissionController::class,'edit'],'permission.edit');
$app->router->get(cp().'/permission/delete/{id}',[PermissionController::class,'delete'],'permission.delete');
$app->router->get(cp().'/permission/restore/{id}',[PermissionController::class,'restore'],'permission.restore');


/**
 * --------API---------
 * all api request
 */
$app->router->get(api().'/artical',[ApiArticalController::class,'get']);
//Run App
$app->run();