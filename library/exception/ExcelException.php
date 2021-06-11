<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 20:13
 */

namespace library\exception;


class ExcelException extends BaseException
{
    public $httpCode = 400;

    public $msg = 'Excel标签获取失败';

    public $code = 103001;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}