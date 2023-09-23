<?php

namespace app\controllers\api;

use app\core\Controller;
use app\models\Artical;

class ApiArticalController extends Controller{
    public function get(){
        
        $articalModel=new Artical();
        return $this->reanderApi(
            [
                $articalModel->get()
            ]
        );
    }
}