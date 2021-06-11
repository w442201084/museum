<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-08
 * Time: 14:53
 */

namespace app\index\model;


use library\helper\WhereHelper;

class UserModel extends BaseModel
{
    protected $table = 'cs_user';

    public function getLists($params)
    {
        $where = WhereHelper::combineWhere($params);
        $lists = $this -> lists($where , $params['page'] , $params['pageSize']);
        return $lists;
    }
}