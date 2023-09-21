<?php 
namespace app\core\middlewares;

class ApiMiddleware {
    /**
     * Summary of execute
     * @return bool
     */
    private $api_token="4a2e8f6bc3d9471a9d0c86e2";
    public function execute():bool{
         
        if($this->isApiAutherize()){
            return true;
        }
        else
            return false;
    }
    public function isApiAutherize():bool{
        $BearerToken=$this->getBearerToken();
        //vd($BearerToken);exit;
        if($BearerToken){
            if($this->api_token==$BearerToken)
                return true;
            else
                return false;
        }
        else
        return false;
    }
    
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();

        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

}