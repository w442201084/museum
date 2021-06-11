<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/30
 * Time: 14:30
 */

namespace library\exception;


class CommunicateException extends BaseException
{
    public $httpCode = 400;

    public $msg = '查询友情链接失败';

    public $code = 105001;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}