<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:31
 */

namespace library\exception;


class RecommendException extends BaseException
{
    public $httpCode = 400;

    public $msg = '评论内容查询失败';

    public $code = 100900;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}