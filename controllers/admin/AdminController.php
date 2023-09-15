<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Controller;

class AdminController extends Controller{
    public function __construct() {
        $this->setLayout('admin');
        $this->setPrevPage('/admin');
    }
    public function get(){
        //$this->setTitle('Dashboard Page');
        return $this->reander('dashboard',['title'=>'Dashboard Page']);
    }    
     
}