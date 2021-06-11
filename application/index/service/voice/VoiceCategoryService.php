<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/12/22
 * Time: 15:40
 */

namespace app\index\service\voice;


use app\index\model\ActModel;
use app\index\model\VoiceCategoryModel;
use library\exception\DbRunTimeException;
use library\exception\ParameterException;
use library\helper\TimeHelper;
use library\helper\WhereHelper;
use think\Db;

class VoiceCategoryService
{
    public function create($params)
    {
        $params['create_time'] = TimeHelper::getNowTime();
        $categoryModel = ( new VoiceCategoryModel() );
        $status = $categoryModel -> allowField(true) ->  save($params);
        return $status;
    }

    public function update($params)
    {
        $catModel = VoiceCategoryModel::get($params['id']);
        if ( empty($catModel) ) {
            throw new ParameterException('查询分类失败');
        } else {
            $status = $catModel -> allowField(true) ->  save($params);
            return $status;
        }
    }

    public function delete($params)
    {
        $catModel = VoiceCategoryModel::get($params['id']);
        if ( empty($catModel) ) {
            throw new ParameterException('查询分类失败');
        } else {
            return $catModel -> delete();
        }
    }

    public function lists($params)
    {
        $model = new VoiceCategoryModel();
        $where = WhereHelper::combineWhere($params);
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        if(!empty($lists['lists'])) {
            $lists['lists'] = array_map(function($row){
                $row['statusAlias'] = $row['logic_status'] == 1 ? '启用' : '禁用';
                return $row;
            } , $lists['lists'] -> toArray());
        }
        return $lists;
    }

    public function operate($params)
    {
        $model = VoiceCategoryModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询分类失败');
        }
        $status = $model -> allowField(true) ->
        save(['logic_status' => $params['logic_status']] , ['id' => $params['id']]);
        return $status;
    }
}