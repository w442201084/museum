<?php


namespace app\api\controller;


use think\App;
use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        $url = config('common.allow_request');
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:'. $url); // *代表
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类>型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
    }
}