<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 18:44
 */

namespace library\exception;


class FileUploadException extends BaseException
{
    public $httpCode = 400;

    public $msg = '图片上传异常';

    public $code = 100700;

    public function getHttpCode()
    {
        return $this -> httpCode;
    }
}