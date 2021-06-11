<?php


namespace app\api\controller;
use access\lib\wechat\AccessToken;
use access\lib\wechat\GlobalAccessToken;
use app\index\service\act\ActService;
use app\index\service\auth\RoleService;
use app\index\service\desc\DescService;
use app\index\service\wechat\WeChatService;
use app\index\validate\act\AppointmentValidate;
use library\helper\OutputHelper;
use think\facade\Request;

class Desc extends Base
{
    /**
     * @desc 预约
     */
    public function info()
    {
       $params = [
            'logic_type' => Request::get('logic_type'),
        ];
        $apiResults = (new DescService()) -> getInfo($params);
        OutputHelper::ajax($apiResults);
    }
}