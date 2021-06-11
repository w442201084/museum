<?php


namespace app\index\validate\ancient;


use app\index\validate\BaseValidate;

class AncientCategoryValidate extends BaseValidate
{
    public $code = 100009;

    protected $rule = [
        'value' => 'require|max:50',
    ];

    protected $message = [
        'value.require' => '分类名称不能为空',
        'value.max' => '分类名称最大长度为50个字符',
    ];
}