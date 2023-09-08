<?php
/**
 * Start Of the Website
 */
require_once __DIR__.'/../vendor/autoload.php';

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

/**
 * Gloabal Varible 
 * 
*/
define('Dir', __DIR__);

/**
 * Config 
 */
$config['db']=[
    'dbhost'=>'localhost',
    'dbn'=>'mvc_db',
    'user'=>'root',
    'password'=>'',
];
#
$config['cpanel']='/cp';
#
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
#
function cp(){
    global $config;
    return $config['cpanel'];
}
#
$app=new Application(dirname(__DIR__),$config);
/**
 * ROUTER 
 */
$app->router->get('/',[SiteController::class,'home']);
$app->router->get('/contact/{depid}/{id2}',[SiteController::class,'contact']);
$app->router->post('/contact',[SiteController::class,'contact']);

$app->router->get('/login',[AuthController::class,'login']);
$app->router->post('/login',[AuthController::class,'login']);

$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);


$app->router->get('/profile',[AuthController::class,'profile'],isAuth:true);
$app->router->get('/logout',[AuthController::class,'logout'],isAuth:true);
/**
 * Admin Panel Links
 */
$app->router->get(cp().'/dashboard',[AdminController::class,'dashboard'],isAuth:true);
/**
 * Category Pages
 */
$app->router->get(cp().'/category',[CategoryController::class,'get'],isAuth:true);
$app->router->get(cp().'/category/add' ,[CategoryController::class,'add'],isAuth:true);
$app->router->post(cp().'/category/add' ,[CategoryController::class,'add'],isAuth:true);
$app->router->get(cp().'/category/edit/{id}',[CategoryController::class,'edit'],isAuth:true);
$app->router->post(cp().'/category/edit/{id}',[CategoryController::class,'edit'],isAuth:true);
$app->router->get(cp().'/category/delete/{id}',[CategoryController::class,'delete'],isAuth:true);
/**
 * Artical Pages
 */
$app->router->get(cp().'/artical',[ArticalController::class,'get'],isAuth:true);
$app->router->get(cp().'/artical/add' ,[ArticalController::class,'add'],isAuth:true);
$app->router->post(cp().'/artical/add' ,[ArticalController::class,'add'],isAuth:true);
$app->router->get(cp().'/artical/edit/{id}',[ArticalController::class,'edit'],isAuth:true);
$app->router->post(cp().'/artical/edit/{id}',[ArticalController::class,'edit'],isAuth:true);
$app->router->get(cp().'/artical/delete/{id}',[ArticalController::class,'delete'],isAuth:true);
$app->router->get(cp().'/artical/delete/photo/{id}',[ArticalController::class,'delete_photo'],isAuth:true);
$app->router->get(cp().'/artical/photo/ismain/{id}/{val}',[ArticalController::class,'ismain_photo'],isAuth:true);
/**
 * Permisions Pages
 */
//user Program
$app->router->get(cp().'/permission/program',[PermisionProgramController::class,'get'],isAuth:true);
$app->router->get(cp().'/permission/program/add' ,[PermisionProgramController::class,'add'],isAuth:true);
$app->router->post(cp().'/permission/program/add' ,[PermisionProgramController::class,'add'],isAuth:true);
$app->router->get(cp().'/permission/program/edit/{id}',[PermisionProgramController::class,'edit'],isAuth:true);
$app->router->post(cp().'/permission/program/edit/{id}',[PermisionProgramController::class,'edit'],isAuth:true);
$app->router->get(cp().'/permission/program/delete/{id}',[PermisionProgramController::class,'delete'],isAuth:true);
$app->router->get(cp().'/permission/program/restore/{id}',[PermisionProgramController::class,'restore'],isAuth:true);
//user Action
$app->router->get(cp().'/permission/action',[PermisionActionController::class,'get'],isAuth:true);
$app->router->get(cp().'/permission/action/add' ,[PermisionActionController::class,'add'],isAuth:true);
$app->router->post(cp().'/permission/action/add' ,[PermisionActionController::class,'add'],isAuth:true);
$app->router->get(cp().'/permission/action/edit/{id}',[PermisionActionController::class,'edit'],isAuth:true);
$app->router->post(cp().'/permission/action/edit/{id}',[PermisionActionController::class,'edit'],isAuth:true);
$app->router->get(cp().'/permission/action/delete/{id}',[PermisionActionController::class,'delete'],isAuth:true);
$app->router->get(cp().'/permission/action/restore/{id}',[PermisionActionController::class,'restore'],isAuth:true);
//user Group
$app->router->get(cp().'/permission/group',[PermisionGroupController::class,'get'],isAuth:true);
$app->router->get(cp().'/permission/group/add' ,[PermisionGroupController::class,'add'],isAuth:true);
$app->router->post(cp().'/permission/group/add' ,[PermisionGroupController::class,'add'],isAuth:true);
$app->router->get(cp().'/permission/group/edit/{id}',[PermisionGroupController::class,'edit'],isAuth:true);
$app->router->post(cp().'/permission/group/edit/{id}',[PermisionGroupController::class,'edit'],isAuth:true);
$app->router->get(cp().'/permission/group/delete/{id}',[PermisionGroupController::class,'delete'],isAuth:true);
$app->router->get(cp().'/permission/group/restore/{id}',[PermisionGroupController::class,'restore'],isAuth:true);

//user Permission
$app->router->get(cp().'/permission',[PermissionController::class,'get'],isAuth:true);
$app->router->get(cp().'/permission/add' ,[PermissionController::class,'add'],isAuth:true);
$app->router->post(cp().'/permission/add' ,[PermissionController::class,'add'],isAuth:true);
$app->router->get(cp().'/permission/edit/{id}',[PermissionController::class,'edit'],isAuth:true);
$app->router->post(cp().'/permission/edit/{id}',[PermissionController::class,'edit'],isAuth:true);
$app->router->get(cp().'/permission/delete/{id}',[PermissionController::class,'delete'],isAuth:true);
$app->router->get(cp().'/permission/restore/{id}',[PermissionController::class,'restore'],isAuth:true);
//Run App
$app->run();