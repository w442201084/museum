<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/8/7
 * Time: 14:15
 */

namespace library\exception;

use think\Exception;

class BaseException extends Exception
{
    public $httpCode;

    public $msg;

    public $code;

    public function __construct($message = "", int $code = 0, Throwable $previous = null)
    {
        $message && $this -> msg = $message;
        $code && $this -> code = $code;
    }

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}