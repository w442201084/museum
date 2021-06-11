<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-01
 * Time: 10:34
 */

namespace app\index\validate;


class CheckEnumType extends BaseValidate
{
    public $code = 100003;

    protected $rule = [
        'menu_type' => 'require|between:1,10'
    ];

    protected $message = [
        'menu_type.require' => '枚举类型不能为空',
        'menu_type.between' => '枚举类型范围有误',
    ];
}