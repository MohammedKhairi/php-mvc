<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller{
    public function home() {
        $param=[
            'name'=>"Mohammed",
        ];
        return $this->reander('home',$param);
    }    
    public function contact() {
        return $this->reander('contact');
    }   
    public function handelContact(Request $request) {
        $body=$request->getBody();
        var_dump($body);exit;
        return $body;

        
    }    
}