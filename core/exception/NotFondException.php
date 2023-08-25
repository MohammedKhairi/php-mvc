<?php 
namespace app\core\exception;
class NotFondException extends \Exception {
     protected $message="Page Not Found";
     protected $code=404;
}