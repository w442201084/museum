<?php


namespace app\index\controller;


use app\index\service\msg\MsgService;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use think\facade\Request;

class Msg
{
    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'user_name' => Request::get('user_name'),
            'user_phone' => Request::get('user_phone'),
            'email' => Request::get('email'),
            'create_time' => Request::get('create_time'),
        ];
        $results = ( new MsgService() ) -> lists($params);
        OutputHelper::ajax($results);
    }
}