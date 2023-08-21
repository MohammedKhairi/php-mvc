<?php
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\core\Application ;
use app\controllers\SiteController ;
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
$app=new Application(dirname(__DIR__),$config);
/**
 * ROUTER 
 */
$app->router->get('/',[SiteController::class,'home']);
$app->router->get('/contact',[SiteController::class,'contact']);
$app->router->post('/contact',[SiteController::class,'handelContact']);

$app->router->get('/login',[AuthController::class,'login']);
$app->router->post('/login',[AuthController::class,'login']);

$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);

/**
 * Run App
 */

$app->run();