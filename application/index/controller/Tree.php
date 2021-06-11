<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/12
 * Time: 19:51
 */

namespace app\index\controller;


use app\index\service\auth\RoleNodeService;
use library\menu\NodeTreeMenu;
use library\helper\OutputHelper;

class Tree extends Base
{
    /**
     * @desc 获取当前权限所模块节点
     */
    public function authority()
    {
        $handle = new RoleNodeService($this);
        $tree = $handle -> lists([
            'pid' => 0 ,
            'logic_level' => 3
        ]);
        OutputHelper::ajax($tree);
    }
}