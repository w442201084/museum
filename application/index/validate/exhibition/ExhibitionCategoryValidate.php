<?php


namespace app\index\validate\exhibition;


use app\index\validate\BaseValidate;

class ExhibitionCategoryValidate extends BaseValidate
{
    public $code = 100008;

    protected $rule = [
        'value' => 'require|max:50',
        'act_id' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'value.require' => '分类名称不能为空',
        'value.max' => '分类名称最大长度为50个字符',
        'content.require' => '内容描述不能为空',
        'act_id.require' => '所属活动不能为空',
    ];
}