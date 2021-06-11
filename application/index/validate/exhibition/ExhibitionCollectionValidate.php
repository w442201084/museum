<?php


namespace app\index\validate\exhibition;


use app\index\validate\BaseValidate;

class ExhibitionCollectionValidate extends BaseValidate
{
    public $code = 100008;

    protected $rule = [
        'coll_name' => 'require|max:50',
        'cat_id' => 'require',
        'content' => 'require',
        'thumb_img' => 'require',
    ];

    protected $message = [
        'coll_name.require' => '藏品名称不能为空',
        'coll_name.max' => '藏品名称最大长度不能超过50个字符',
        'content.require' => '内容描述不能为空',
        'cat_id.require' => '所属分类不能为空',
        'thumb_img.require' => '主图不能为空',
    ];
}