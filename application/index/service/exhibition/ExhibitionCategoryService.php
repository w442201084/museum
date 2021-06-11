<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/12/22
 * Time: 15:40
 */

namespace app\index\service\exhibition;


use app\index\model\ActCategoryModel;
use app\index\model\ActModel;
use library\exception\DbRunTimeException;
use library\exception\ParameterException;
use library\helper\TimeHelper;
use library\helper\WhereHelper;
use think\Db;

class ExhibitionCategoryService
{
    public function create($params)
    {
        if( $params['act_id'] <=0 ) {
            throw new ParameterException('选择的活动不能为空');
        }
        $params['create_time'] = TimeHelper::getNowTime();
        $act = ActModel::get($params['act_id']);
        if(empty($act)) {
            throw new ParameterException('查询活动失败');
        }
        try {
            Db::startTrans();
            $params['act_name'] = $act -> act_name;
            $categoryModel = ( new ActCategoryModel() );
            $status = $categoryModel -> allowField(true) ->  save($params);
//            $this -> actAddCategory($params['act_id'] , $categoryModel -> id);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new DbRunTimeException('网络开小差了，请稍后再试');
        }
        return $status;
    }

    public function update($params)
    {
        if( $params['act_id'] == 0 ) {
            throw new ParameterException('获取选择的活动失败');
        }
        $catModel = ActCategoryModel::get($params['id']);
//        if ( empty($catModel) ) {
//            throw new ParameterException('查询分类失败');
//        }
        try {
            $actModel = ActModel::get($params['act_id']);
            if( empty($actModel) ) {
                throw new ParameterException('查询活动失败');
            }
            Db::startTrans();
//            if( $params['act_id'] != $catModel -> act_id ) {
//                $this -> actAddCategory($params['act_id'] , $params['id']);
//                if( $catModel -> act_id > 0 ) {
//                    $this -> removeAddCategory($catModel -> act_id , $params['id']);
//                }
//            }
            $params['act_name'] = $actModel -> act_name;
            $status = $catModel -> allowField(true) -> save($params);
            Db::commit();
            return $status;
        } catch (\Exception $e) {
            Db::rollback();
            throw new DbRunTimeException('网络开小差了，请稍后再试');
        }
    }

    public function delete($params)
    {
        $catModel = ActCategoryModel::get($params['id']);
        if ( empty($catModel) ) {
            throw new ParameterException('查询分类失败');
        } else {
            try {
                Db::startTrans();
                if( $catModel -> act_id > 0 ) {
                    $this -> removeAddCategory($catModel -> act_id , $params['id']);
                }
                $status = $catModel -> delete();
                Db::commit();;
                return $status;
            } catch (\Exception $e ){
                Db::rollback();
                throw new DbRunTimeException('网络开小差了，请稍后再试');
            }
        }
    }

    public function lists($params)
    {
        $model = new ActCategoryModel();
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
        $model = ActCategoryModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询分类失败');
        }
        $status = $model -> allowField(true) ->
        save(['logic_status' => $params['logic_status']] , ['id' => $params['id']]);
        return $status;
    }

    public function actAddCategory($actId , $categoryId)
    {
        $model = ActModel::get($actId);
        if( empty($model) ) {
            throw new ParameterException('查询活动失败');
        }
        $catId = $model -> cat_id;
        if( empty($catId) ) {
            $catId = "|{$categoryId}|";
        } else {
            $catId .= "{$categoryId}|";
        }
        $model -> cat_id = $catId;
        $model -> save();
    }

    public function removeAddCategory($actId , $categoryId)
    {
        $model = ActModel::get($actId);
        if( empty($model) ) {
            throw new ParameterException('查询活动失败');
        }
        $catId = $model -> cat_id;
        $catId = str_replace("|{$categoryId}" , '', $catId );
        $model -> cat_id = $catId;
        $model -> save();
    }
}