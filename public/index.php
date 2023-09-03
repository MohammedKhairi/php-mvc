<?php
/**
 * Start Of the Website
 */
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\core\Application ;
use app\controllers\SiteController ;
use app\controllers\admin\AdminController ;
use app\controllers\admin\CategoryController;

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
$app->router->get(cp().'/category',[CategoryController::class,'get'],isAuth:true);
$app->router->get(cp().'/category/add' ,[CategoryController::class,'add'],isAuth:true);
$app->router->post(cp().'/category/add' ,[CategoryController::class,'add'],isAuth:true);
$app->router->get(cp().'/category/edit/{id}',[CategoryController::class,'edit'],isAuth:true);
$app->router->post(cp().'/category/edit/{id}',[CategoryController::class,'edit'],isAuth:true);
$app->router->get(cp().'/category/delete/{id}',[CategoryController::class,'delete'],isAuth:true);

//Run App
$app->run();