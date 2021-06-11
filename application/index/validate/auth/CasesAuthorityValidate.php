<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-26
 * Time: 21:52
 */

namespace app\index\validate\auth;


use app\index\validate\BaseValidate;

class CasesAuthorityValidate extends BaseValidate
{
    public $code = 104002;

    protected $rule = [
        'user_id' => 'require',
        'college_id' => 'require',
        'logic_type' => 'require|between:1,4',
        'user_no' => 'require',
        'email' => 'require|email',
    ];

    protected $message = [
        'user_id.require' => '操作人id不能为空',
        'college_id.require' => '操作人所属学院不能为空',
        'logic_type.require' => '案例权限类型不能空位',
        'logic_type.between' => '案例权限类型操作范围有误',
        'user_no.require' => '学号/工号不能为空',
        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式有误',
    ];
}