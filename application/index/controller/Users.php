<?php


namespace app\index\controller;


use app\index\service\menu\MenuService;
use library\helper\OutputHelper;

class Users extends Base
{
    public function info()
    {
        $user = $this -> getUserInfo();
        $results = [
            'login_name' => $user['login_name'],
            'real_name' => $user['real_name'],
            'college_name' => $colleges[$user['college_id']] ?? '超级管理员',
        ];
        OutputHelper::ajax($results);
    }
}