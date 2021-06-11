<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-01
 * Time: 10:34
 */

namespace app\index\validate;


class CheckPageInt extends BaseValidate
{
    public $code = 100002;

    protected $rule = [
        'page' => 'require|checkInt',
        'pageSize' => 'require|checkInt'
    ];

    protected $message = [
        'page.require' => '页码标识不能为空',
        'pageSize.require' => '页码大小标识不能为空',
    ];
}