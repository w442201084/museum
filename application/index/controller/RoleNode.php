<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-26
 * Time: 21:48
 */

namespace app\index\controller;

use app\index\service\auth\RoleNodeService;
use app\index\validate\CheckIdInt;
use think\facade\Request;
use library\helper\OutputHelper;

/**
 * @desc 角色节点维护
 * Class RoleNode
 * @package app\index\controller
 */
class RoleNode extends Base
{
    public function add()
    {
        $params = [
            'node_name' => Request::post('node_name'),
            'node_path' => Request::post('node_path'),
            'pid' => Request::post('pid' , 0),
            'logic_menu' => Request::post('logic_menu'),
            'logic_level' => Request::post('logic_level'),
        ];
        $status = ( new RoleNodeService() ) -> add($params);
        OutputHelper::ajax($status);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'node_name' => Request::post('node_name'),
            'node_path' => Request::post('node_path'),
            'pid' => Request::post('pid'),
            'logic_menu' => Request::post('logic_menu'),
            'logic_level' => Request::post('logic_level'),
        ];
        $status = ( new RoleNodeService() ) -> update($params);
        OutputHelper::ajax($status);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::post('id'),
        ];
        $status = ( new RoleNodeService() ) -> delete($params);
        OutputHelper::ajax($status);
    }

    public function lists()
    {
        $params = [
            'pid' => Request::get('pid'),
            'logic_level' => Request::get('logic_level'),
        ];
        $tree = ( new RoleNodeService() ) -> lists($params);
        OutputHelper::ajax($tree);
    }
}