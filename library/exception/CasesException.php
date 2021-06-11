<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 20:13
 */

namespace library\exception;


class CasesException extends BaseException
{
    public $httpCode = 400;

    public $msg = '案例基础信息查询失败';

    public $code = 102001;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}