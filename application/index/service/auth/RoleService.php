<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:13
 */

namespace app\index\service\auth;


use app\index\model\RoleModel;
use app\index\validate\auth\RoleValidate;
use library\exception\RoleException;
use library\helper\PageHelper;
use library\helper\WhereHelper;
use think\Paginator;

class RoleService
{
    public function add($params)
    {
        ( new RoleValidate() ) -> run($params);
        $model = new RoleModel();
        $status = $model -> allowField(true) -> save($params);
        return $status;
    }

    public function update($params)
    {
        ( new RoleValidate() ) -> run($params);
        $row = RoleModel::get($params['id']);
        if( empty($row) ) {
            throw new RoleException();
        }
        $model = new RoleModel();
        $status = $model -> allowField(true) ->
            save($params , ['id' => $params['id']]);
        return $status;
    }

    public function logic_delete($params)
    {
        $row = RoleModel::get($params['id']);
        if( empty($row) ) {
            throw new RoleException();
        }
        $model = new RoleModel();
        $status = $model -> allowField(true) ->
        save(['logic_status' => 0] , ['id' => $params['id']]);
        return $status;
    }

    public function lists($params)
    {
        $params['logic_status'] = 1;
        $where = WhereHelper::combineWhere($params);
        $lists = ( new RoleModel() ) -> lists( $where , $params['page'] , $params['pageSize'] );
        return $lists;
    }
}