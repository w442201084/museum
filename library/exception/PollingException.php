<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/30
 * Time: 14:30
 */

namespace library\exception;


class PollingException extends BaseException
{
    public $httpCode = 400;

    public $msg = '轮播图查询失败';

    public $code = 100801;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}