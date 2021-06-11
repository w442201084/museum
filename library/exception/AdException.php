<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 20:13
 */

namespace library\exception;


class AdException extends BaseException
{
    public $httpCode = 400;

    public $msg = '图文内容记录查询失败';

    public $code = 101001;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}