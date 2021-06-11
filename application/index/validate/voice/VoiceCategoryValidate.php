<?php


namespace app\index\validate\voice;


use app\index\validate\BaseValidate;

class VoiceCategoryValidate extends BaseValidate
{
    public $code = 100010;

    protected $rule = [
        'value' => 'require|max:50',
    ];

    protected $message = [
        'value.require' => '分类名称不能为空',
        'value.max' => '分类名称最大长度为50个字符',
    ];
}