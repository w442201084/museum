<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:07
 */

namespace app\index\controller;

use app\index\service\login\LoginService;
use app\index\validate\login\LoginValidate;
use library\helper\OutputHelper;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Request;

class Login extends Controller
{
    public function index()
    {
        $params = [
            'login_name' => Request::post('login_name'),
            'captcha' => Request::post('captcha'),
            'login_pswd' => Request::post('login_pswd')
        ];
        $results = ( new LoginService() ) -> login($params);
        OutputHelper::ajax($results , 0 );
    }

    public function logOut()
    {
        $results = ( new LoginService() ) -> logout();
        OutputHelper::ajax($results , 0 );
    }

    /**
     * @desc 返回一个验证码
     * @return \think\Response
     */
    public function captcha()
    {
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>    false,
            'useCurve' => false
        ];
        $captcha = new Captcha($config);
        return $captcha -> entry();
    }
}