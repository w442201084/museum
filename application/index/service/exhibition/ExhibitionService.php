<?php


namespace app\index\service\exhibition;


use app\index\model\ActModel;
use app\index\model\ActCategoryModel;
use library\exception\ParameterException;
use library\helper\ImgHelper;
use library\helper\TimeHelper;
use library\helper\WhereHelper;
use think\Db;

class ExhibitionService
{
    public function add($params)
    {
        Db::startTrans();
        try {
            $model = new ActModel();
            $params['create_time'] = TimeHelper::getNowTime();
//            if( strlen($params['cat_id']) > 0 ) {
//                $catId = implode(',' , explode('|' , $params['cat_id']));
//                $params['cat_id'] = '|' . $params['cat_id'] . '|';
//                $status = $model -> allowField(true) -> save($params);
//                Db::execute(" update cs_act_category set act_id = {$model->id} , act_name = '{$model->act_name}' where id in ({$catId}) ");
//            } else {
//                $status = $model -> allowField(true) -> save($params);
//            }
//            empty($params['act_start_time']) && $params['act_start_time'] = 0;
//            empty($params['act_end_time']) && $params['act_end_time'] = 0;
            $status = $model -> allowField(true) -> save($params);
            Db::commit();
            return $status;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ParameterException('添加失败，请稍后再试');
        }
    }

    public function update($params)
    {
        $model = ActModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询记录失败');
        } else {
            try {
//                $nowCatIds = explode('|' , $params['cat_id']);
//                $actCatIds = explode('|' , trim($model -> cat_id , '|'));
//                $diff = array_diff($actCatIds , $nowCatIds);
//                if(!empty($diff)) {
//                    $diff = implode(',' , $diff);
//                    if(!empty($diff)) {
//                        Db::execute(" update  cs_act_category set act_id = 0 , act_name = ''  where id in ({$diff}) ");
//                    }
//                }
//                if(strlen($params['cat_id']) > 0) {
//                    $params['cat_id'] = '|' . $params['cat_id'] . '|';
//                }
//                $catId = implode(',' , $nowCatIds);
//                if(!empty($catId)) {
//                    Db::execute(" update cs_act_category set act_id = {$model->id} , act_name = '{$params['act_name']}'  where id in ({$catId}) ");
//                }
                $status = $model -> allowField(true) -> save($params);
                Db::commit();
                return $status;
            } catch (\Exception $e) {
                throw new ParameterException('操作失败，请稍后再试');
            }
        }
    }

    public function otherCategory($params)
    {
        $model = new ActCategoryModel();
        if(strlen($params['actId']) > 0)  {
            $actId = explode(',' ,$params['actId']);
            $actId[] = 0;
        } else {
            $actId = [0];
        }
        $where = [['act_id' , 'in' , $actId]];
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        return $lists;
    }

    public function allCategory()
    {
        $cateLists = ActCategoryModel::select();
        return $cateLists;
    }

    public function lists($params)
    {
        $model = new ActModel();
        $lists = $model -> getLists($params);
         if(!empty($lists['lists'])) {
            $lists['lists'] = array_map(function($row){
                $row['formatStartTime'] = $row['act_start_time'] ?
                    TimeHelper::formatYMD($row['act_start_time'] / 1000) : '-';
                $row['formatEndTime'] = $row['act_end_time'] ?
                    TimeHelper::formatYMD($row['act_end_time'] / 1000) : '-';
                $row['statusAlias'] = $row['logic_status'] == 1 ? '启用' : '禁用';
                $row['actTypeAlias'] = $row['act_type'] == 1 ? '基本陈列' : '精彩特展';
//                $catNames = implode(',' ,array_column($row['cat_lists'] , 'value')) ?? '-';
//                $row['catNameLists'] = mb_strimwidth($catNames, 0, 12, '...');
//                $row['catIds'] = array_column($row['cat_lists'] , 'id');
                $row['img_link'] = ImgHelper::addHost($row['thumb_img']);
                return $row;
            } , $lists['lists'] -> toArray());
        }
        return $lists;
    }

    public function delete($params)
    {
        $model = ActModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询记录失败');
        } else {
            Db::startTrans();
            try {
                Db::execute(" update cs_act_category set act_id = 0 where act_id = ({$params['id']}) ");
                $status = $model -> delete();
                Db::commit();
                return $status;
            } catch (\Exception $e) {
                Db::rollback();
                throw new ParameterException('操作失败，请稍后再试');
            }
        }
    }

    public function operate($params)
    {
        $model = ActModel::get($params['id']);
        if(empty($model)) {
            throw new ParameterException('查询记录失败');
        }
        $status = $model -> allowField(true) ->
            save(['logic_status' => $params['logic_status']] , ['id' => $params['id']]);
        return $status;
    }
}