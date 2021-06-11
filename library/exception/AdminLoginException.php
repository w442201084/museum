<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-02
 * Time: 10:36
 */

namespace library\exception;


class AdminLoginException extends BaseException
{
    public $httpCode = 200;

    public $msg = '登录失败';

    public $code = 20000;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}