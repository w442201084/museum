<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:17
 */

namespace library\exception;


class DbRunTimeException extends BaseException
{
    public $httpCode = 400;

    public $msg = 'error parameter';

    public $code = 200010;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}