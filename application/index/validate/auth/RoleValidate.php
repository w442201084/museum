<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:14
 */

namespace app\index\validate\auth;


use app\index\validate\BaseValidate;

class RoleValidate extends BaseValidate
{
    public $code = 100400;

    protected $rule = [
        'role_name' => 'require|max:10',
        'role_nodes' => 'require',
    ];

    protected $message = [
        'role_name.require' => '角色名称不能为空',
        'role_nodes.require' => '权限节点不能为空',
        'role_name.max' => '角色名称最大长度不能超过10个字节',
    ];

}