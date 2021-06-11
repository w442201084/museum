<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:11
 */

namespace app\index\controller;


use app\index\service\auth\RoleService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use think\facade\Request;

class UserRole extends Base
{
    public function add()
    {
        $params = [
            'role_name' => Request::get('role_name'),
            'role_nodes' => Request::get('role_nodes'),
        ];
        $status = ( new RoleService() ) -> add($params);
        OutputHelper::ajax($status);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'role_name' => Request::get('role_name'),
            'role_nodes' => Request::get('role_nodes'),
            'id' => Request::get('id'),
        ];
        $status = ( new RoleService() ) -> update($params);
        OutputHelper::ajax($status);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
        ];
        $status = ( new RoleService() ) -> logic_delete($params);
        OutputHelper::ajax($status);
    }

    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'role_name' => Request::get('role_name'),
        ];
        $status = ( new RoleService() ) -> lists($params);
        OutputHelper::ajax($status);
    }
}