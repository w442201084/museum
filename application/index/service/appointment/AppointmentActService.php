<?php


namespace app\index\service\appointment;


use app\index\model\AppointmentActModel;
use library\exception\ParameterException;
use library\helper\WhereHelper;

class AppointmentActService
{
    public function create($params)
    {
        $categoryModel = ( new AppointmentActModel() );
        $status = $categoryModel -> allowField(true) ->  save($params);
        return $status;
    }

    public function update($params)
    {
        $catModel = AppointmentActModel::get($params['id']);
        if ( empty($catModel) ) {
            throw new ParameterException('查询活动失败');
        } else {
            $status = $catModel -> allowField(true) ->  save($params);
            return $status;
        }
    }

    public function delete($params)
    {
        $catModel = AppointmentActModel::get($params['id']);
        if ( empty($catModel) ) {
            throw new ParameterException('查询活动失败');
        } else {
            return $catModel -> delete();
        }
    }

    public function lists($params)
    {
        $model = new AppointmentActModel();
        $where = WhereHelper::combineWhere($params);
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        return $lists;
    }

    public function operate($params)
    {
        $model = AppointmentActModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询活动失败');
        }
        $status = $model -> allowField(true) ->
        save(['logic_status' => $params['logic_status']] , ['id' => $params['id']]);
        return $status;
    }
}