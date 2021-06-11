<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-26
 * Time: 21:52
 */

namespace app\index\validate\auth;


use app\index\validate\BaseValidate;

class RoleNodeValidate extends BaseValidate
{
    public $code = 100500;

    protected $rule = [
        'node_name' => 'require|max:10',
        'node_path' => 'require|max:100',
        'pid' => 'require|checkInt',
        'logic_menu' => 'require|between:0,1',
        'logic_level' => 'require|between:1,100',
    ];

    protected $message = [
        'node_name.require' => '节点名称不能为空',
        'node_name.max' => '节点名称不能超过10个字符',
        'node_path.require' => '节点路径不能为空',
        'node_path.max' => '节点路径不能超过100个字符',
        'pid.require' => '节点父节点不能为空',
        'logic_menu.require' => '节点类型不能为空',
        'logic_menu.between' => '节点类型参数错误',
        'logic_level.require' => '节点层级不能为空',
        'logic_level.between' => '节点层级超过最大上限',
    ];
}