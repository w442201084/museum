<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-01
 * Time: 10:33
 */

namespace app\index\service\login;

use app\index\model\AdminModel;
use app\index\service\common\CommonRule;
use app\index\service\common\Params;
use app\index\validate\CheckIdInt;
use app\index\validate\login\LoginValidate;
use library\exception\AdminLoginException;
use library\helper\TimeHelper;

class LoginService
{
    public function login($params)
    {
        ( new LoginValidate() ) -> run();
        $adminModel = new AdminModel();
        $row = $adminModel -> where('login_name' , trim($params['login_name'])) -> find();
        if( empty($row) ) {
            throw new AdminLoginException('查询用户失败' , 100000);
        }
        if( $row -> login_pswd != CommonRule::passwordEncrypt($params['login_pswd']) ) {
            throw new AdminLoginException('用户密码错误' , 100000);
        }
        $userInfo = $row -> toArray();
        $userInfo['login_time'] = time();
        $tokenId = CommonRule::encode(json_encode($userInfo) , config('rule.login_skey'));
        $row -> save([
            'last_login_time' => TimeHelper::getNowTime()
        ]);
        session('admin_login_token' , $tokenId);
        session('admin_login_name' , CommonRule::encode($userInfo['login_name']));
        session('admin_login_pswd' , CommonRule::encode($userInfo['login_pswd']));
        return ['msg' => '登录成功' , 'tokenId' => $tokenId];
    }

    public function logout()
    {
        session('admin_login_token' , null);
        session('admin_login_name' , null);
        session('admin_login_pswd' , null);
        return true;
    }
}