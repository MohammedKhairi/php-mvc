<?php 
namespace app\core\exception;
class ForbiddenException extends \Exception {
    
     protected $message="You dont have Permaission to access this page";
     protected $code=403;
}