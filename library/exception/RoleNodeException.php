<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:31
 */

namespace library\exception;


class RoleNodeException extends BaseException
{
    public $httpCode = 400;

    public $msg = '查询节点信息失败';

    public $code = 100501;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}