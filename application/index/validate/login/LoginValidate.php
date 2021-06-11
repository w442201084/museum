<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-01
 * Time: 10:43
 */

namespace app\index\validate\login;


use app\index\validate\BaseValidate;
use think\captcha\Captcha;

class LoginValidate extends BaseValidate
{
    public $code = 100100;

    protected $rule = [
        'captcha' => 'require|checkCap',
        'login_name' => 'require',
        'login_pswd' => 'require'
    ];

    protected $message = [
        'captcha.require' => '验证码不能为空',
        'captcha.checkCap' => '验证码校验失败',
        'login_name.require' => '用户名不能为空',
        'login_pswd.require' => '密码不能为空'
    ];

    public function checkCap($value) {
        return true;
        $captcha = new Captcha();
        return $captcha -> check($value);
    }
}