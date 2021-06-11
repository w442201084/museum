<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-01
 * Time: 10:34
 */

namespace app\index\validate;


class CheckIdInt extends BaseValidate
{
    public $code = 100001;

    protected $rule = [
        'id' => 'require|checkInt'
    ];

    protected $message = [
        'id.require' => 'id标识不能为空',
        'id.checkInt' => 'id必需为正整数',
    ];
}