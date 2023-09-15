<?php 
namespace app\core\middlewares;
use app\core\Application;
use app\models\Permission;

class AuthMiddleware {
    public $permission;
    public function __construct() {
        $this->permission = new Permission();
    }
    /**
     * Summary of execute
     * @return bool
     */
    public function execute():bool{
         
        if(Application::$app->isAuth()){
            return true;
        }
        else
            return false;
    }
    public function isPermission(string $program,string $section ,string $method):bool{
        //user info from session 
        $u_info=Application::$app->session->get('user');
        //check if user have permission on the program
        $D=$this->permission->getWithProgram($u_info['id'],$program,$section,$method);
        //vd($D);exit;
        if(!empty($D)){
            return true;
        }
        else
        return false;

    }


}