<?php
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\core\Application ;
use app\controllers\SiteController ;
use app\core\middlewares\AuthMiddleware;

/**
 * Config 
 */
$dotenv=Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config['db']=[
    'dbhost'=>$_ENV['DB_HOST'],
    'dbn'=>$_ENV['DB_NAME'],
    'user'=>$_ENV['DB_USER'],
    'password'=>$_ENV['DB_PASSWORD'],
];
#
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
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


$app->router->get('/profile',[AuthController::class,'profile'],true);
$app->router->get('/logout',[AuthController::class,'logout'],true);

/**
 * Run App
 */

$app->run();