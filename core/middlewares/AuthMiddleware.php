<?php 
namespace app\core\middlewares;
use app\core\Application;
use app\models\PermisionGroup;

class AuthMiddleware {
    public $permission;
    public function __construct() {
        $this->permission = new PermisionGroup();
    }
    /**
     * Summary of execute
     * @return bool
     */
    public function execute():bool{
         
        if(Application::$app->isAuth())
            return true;
        else
            return false;
    }
    public function isPermission(string $lvl ,string $program,string $method):bool{
        //check if user have permission on the program
        $D=$this->permission->getWithProgramAction($lvl,$program,$method);
        //vd($D);exit;
        if(!empty($D))
            return true;
        else
            return false;
    }


}