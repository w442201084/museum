<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/18
 * Time: 14:04
 */

namespace library\menu;


class UserMenu
{
    /**
     * @desc 操作方法对应的日志名称
     */
    const OPT_LOG_ACTION_ALIAS = [
        'add' => '添加',
        'delete' => '删除',
        'update' => '更新',
        'check' => '审核',
    ];

    const LOGIC_CHECK_STATUS_ALIAS = [
        1 => '审核成功',
        2 => '审核失败',
    ];

    // 角色对应的默认权限配置
    const ROLE_TYPE_DEFAULT_AUTHORITY = [
        1 => [1,2],
        2 => [1,2,3],
        3 => [1,2,3,4],
    ];
}