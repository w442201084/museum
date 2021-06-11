<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:17
 */

namespace library\exception;


class ParameterException extends BaseException
{
    public $httpCode = 400;

    public $msg = 'error parameter';

    public $code = 20000;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}