<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 11/15/20
 * Time: 11:48 AM
 */

namespace library\menu;


class CasesAuthorityMenu
{
    // 1 => 上传 2 => 浏览 3 => 下载 4 => 审稿
    const OPT_LOG_LOGIC_TYPE_ALIAS = [
        1 => '案例上传',
        2 => '案例浏览',
        3 => '案例下载',
        4 => '案例审稿',
    ];

    /**
     * @desc 操作方法对应的日志名称
     */
    const OPT_LOG_ACTION_ALIAS = [
        'add' => '分配',
        'delete' => '回收'
    ];
}