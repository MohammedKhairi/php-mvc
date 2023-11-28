<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Contact;
use app\models\Department;

class SiteController extends Controller{

    public function home() {
        $param=[
            'name'=>"Home Page",
        ];
        return $this->reander('home',$param);
    }
     
}