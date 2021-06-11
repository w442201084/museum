<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 20:13
 */

namespace library\exception;


class CasesAuthorityException extends BaseException
{
    public $httpCode = 400;

    public $msg = '用户案例权限查询失败';

    public $code = 104001;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}