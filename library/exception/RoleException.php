<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:31
 */

namespace library\exception;


class RoleException extends BaseException
{
    public $httpCode = 400;

    public $msg = '查询角色信息失败';

    public $code = 100401;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}