<?php


namespace app\index\service\wechat;


use access\lib\wechat\GlobalAccessToken;
use access\lib\wechat\MsgTpl;
use access\lib\wechat\User;
use app\index\model\TicketInfoModel;
use app\index\service\cache\RedisHandle;
use think\facade\Cache;

class WeChatService
{
    /**
     * @desc 获取微信全局token
     * @return mixed
     * @throws \Exception
     */
    public function getGlobalAccessToken()
    {
        $cacheKey = 'wechat:global:token';
        $redisHandle = RedisHandle::getInstance();
        if( !$token = $redisHandle -> get($cacheKey) ) {
            $accessToken = new GlobalAccessToken();
            $token = $accessToken -> getGlobalAccessToken();
            $redisHandle -> set($cacheKey , $token , 3600);
        }
        return $token;
    }

    public function sendMsg($openId , $data)
    {
        $token = $this -> getGlobalAccessToken();
        $handle = new MsgTpl($token['access_token']);
        $sendData = [
            'touser' => $openId,
            'template_id' => config('msgTpl.wechat_msg_tpl_id'),
            "url" => config('common.appointment'),
            'data' => [
                "first" => [
                    "value" => '您已成功预约湘潭博物馆门票',
                    "color"=> "#173177"
                ],
                "keyword1" => [
                    "value" => $data['keyword1'],
                    "color"=> "#173177"
                ],
                "keyword2" => [
                    "value" => $data['keyword2'],
                    "color"=> "#173177"
                ],
                "keyword3" => [
                    "value" => $data['keyword3'],
                    "color"=> "#173177"
                ],
                "keyword4" => [
                    "value" => $data['keyword4'],
                    "color"=> "#173177"
                ],
                "keyword5" => [
                    "value" => $data['keyword5'],
                    "color"=> "#173177"
                ],
                "remark" => [
                    "value" => $data['remark'],
                    "color"=> "#173177"
                ],
            ]
        ];
        $apiResults = $handle -> sendMsg(json_encode($sendData));
        return $apiResults;
    }

    public function getUserInfo($openId)
    {
        $token = $this -> getGlobalAccessToken();
        if($token['access_token']) {
            $user = new User($token['access_token'] , $openId);
            $info = $user -> getUserInfo();
            return $info;
        } else {
            return [];
        }
    }
}