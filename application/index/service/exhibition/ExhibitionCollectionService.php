<?php


namespace app\index\service\exhibition;


use app\index\model\ActCollectionModel;
use app\index\model\ActModel;
use app\index\model\ActCategoryModel;
use library\exception\ParameterException;
use library\helper\ImgHelper;
use library\helper\TimeHelper;
use library\helper\WhereHelper;
use think\Db;

class ExhibitionCollectionService
{
    public function create($params)
    {
        $model = new ActCollectionModel();
        $params['create_time'] = TimeHelper::getNowTime();
        $status = $model -> allowField(true) -> save($params);
        return $status;
    }

    public function update($params)
    {
        $model = ActCollectionModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询藏品失败');
        } else {
            $status = $model -> allowField(true) -> save($params);
            return $status;
        }
    }


    public function lists($params)
    {
        $model = new ActCollectionModel();
        $lists = $model -> getLists($params);
         if(!empty($lists['lists'])) {
            $lists['lists'] = array_map(function($row){
                $row['statusAlias'] = $row['logic_status'] == 1 ? '启用' : '禁用';
                $row['cat_name'] = $row['cat_lists']['value'];
                $row['img_link'] = ImgHelper::addHost($row['thumb_img']);
                return $row;
            } , $lists['lists'] -> toArray());
        }
        return $lists;
    }

    public function delete($params)
    {
        $model = ActCollectionModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询记录失败');
        } else {
            return $model -> delete();
        }
    }

    public function operate($params)
    {
        $model = ActCollectionModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询记录失败');
        }
        $status = $model -> allowField(true) ->
            save(['logic_status' => $params['logic_status']] , ['id' => $params['id']]);
        return $status;
    }
}