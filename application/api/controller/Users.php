<?php


namespace app\api\controller;


use app\api\service\UserService;
use app\index\service\act\ActService;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use think\facade\Request;

class Users extends Base
{
    public function ticket()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'openId' => Request::get('openId'),
        ];
        $apiResults = ( new UserService() ) -> ticket($params);
        OutputHelper::ajax($apiResults);
    }

    public function appointment()
    {
        $params = [
            'openId' => Request::post('openId'),
            'tickets' => Request::post('tickets'),
        ];
        $apiResults = (new ActService()) -> appointment($params);
        OutputHelper::ajax($apiResults);
    }
}