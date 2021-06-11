<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:07
 */

namespace app\index\controller;


use app\index\service\auth\RoleNodeService;
use app\index\service\common\CommonRule;
use library\exception\AdminLoginException;
use library\menu\NodeTreeMenu;
use think\Controller;
use think\facade\Request;

class Base extends Controller
{
    protected $user;

    public function initialize()
    {
        if( empty(session('admin_login_token')) ) {
            throw new AdminLoginException('非法操作' , 100000);
        }
        $userInfo = json_decode(CommonRule::decode(
            session('admin_login_token') , config('rule.login_skey')) , true);

        if( time() - $userInfo['login_time'] > config('rule.login_expire_time') ) {
            throw new AdminLoginException('用户身份已过期，请重新登录' , 100000);
        }

        if( $userInfo['login_name'] !=
            CommonRule::decode(session('admin_login_name'))) {
            throw new AdminLoginException('非法操作' , 100000);
        }

        if( $userInfo['login_pswd'] != CommonRule::decode(session('admin_login_pswd') )) {
            throw new AdminLoginException('非法操作' , 100000);
        }
        foreach ($userInfo as $k => $v) {
            $this -> {$k} = $v;
        }
        // 权限接口校验以及操作日志入库
        $handle = new RoleNodeService($this);
        $tree = $handle -> lists([
            'pid' => 0 ,
            'logic_level' => 3
        ] , false);
        $nodeValue = array_column($tree , 'node_value');
        $allowAccess = config('allow.');
        $nodeValue = array_merge($nodeValue , $allowAccess);
        $controller = Request::instance()->controller();
        $action = Request::instance()->action();
        $allow = $controller . '/' . $action;
        if( $this -> role_id != NodeTreeMenu::ADMIN_ROLE_NODE ) {
            if( !in_array($allow , $nodeValue) ) {
                throw new AdminLoginException('当前没有权限操作该模块' , 100000);
            }
        }
    }

    /**
     * @desc 当前登录用户信息
     * @return mixed
     */
    public function getUserInfo()
    {
        $userInfo = json_decode(CommonRule::decode(
            session('admin_login_token') , config('rule.login_skey')) , true);
        return $userInfo;
    }
}