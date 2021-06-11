<?php


namespace app\index\service\msg;


use app\index\model\UserMsgModel;
use library\helper\WhereHelper;

class MsgService
{
    public function lists($params)
    {
        $model = new UserMsgModel();
        $where = WhereHelper::combineWhere($params);
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        return $lists;
    }
}