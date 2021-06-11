<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 20:13
 */

namespace library\exception;


class MenuAdContentException extends BaseException
{
    public $httpCode = 400;

    public $msg = '查找枚举广告类型失败';

    public $code = 100601;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}