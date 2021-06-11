<?php


namespace app\index\validate\act;


use app\index\validate\BaseValidate;

class TagContentValidate extends BaseValidate
{
    public $code = 100020;

    protected $rule = [
        'logic_type' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'logic_type.require' => '类型不能为空',
        'content.require' => '内容不能为空',
    ];
}