<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/12/17
 * Time: 15:50
 */

namespace app\index\controller;


use access\lib\wechat\AccessToken;
use access\lib\wechat\GlobalAccessToken;
use access\lib\wechat\User;
use app\index\service\wechat\WeChatService;
use library\exception\BaseException;
use think\Exception;
use library\helper\OutputHelper;

class WeChat
{
    public function code()
    {
        $url = config('common.allow_request');
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:'. $url); // *代表
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类>型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
        try {
            $code = input('get.code');
            $state = input('get.state');
            $accessToken = new AccessToken($code);
            $token = $accessToken -> getAccessTokenByCode();
            $token['url'] = $state;
            OutputHelper::ajax($token);
        } catch (\Exception $e) {
            OutputHelper::ajax(['code' => $e -> getCode() , 'msg' => $e -> getMessage()]);
        }
    }

    public function getAccessToken()
    {
        try {
            $handle = new WeChatService();
            $handle -> sendMsg('oOmVn5nTwxj7tXbjAtZ7S5qJkzoY' , []);
//            OutputHelper::ajax($token);
        } catch (\Exception $e) {
            OutputHelper::ajax(['code' => $e -> getCode() , 'msg' => $e -> getMessage()]);
        }
    }

    public function info()
    {
        $accessToken = new GlobalAccessToken();
        $token = $accessToken -> getGlobalAccessToken();
        if($token['access_token']) {
            $user = new User($token['access_token'] , 'oOmVn5seW0rnwygK1wP_Xbn4z1T4---');
            $info = $user -> getUserInfo();
        }
    }

}