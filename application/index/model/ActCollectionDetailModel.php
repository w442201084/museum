<?php


namespace app\index\model;


use library\helper\WhereHelper;

class ActCollectionDetailModel extends BaseModel
{
    protected $table = 'cs_act_collection';

    public function catLists()
    {
        return $this -> hasOne('ActCategoryModel' , 'id' , 'cat_id');
    }

    public function getLists($params)
    {
        $where = WhereHelper::combineWhere($params);
        $count = self::with(['catLists']) ->
        where($where) -> count();
        $lists = self::with(['catLists']) ->
        where($where) -> page($params['page'] , $params['pageSize']) -> order('id' , 'desc')
            -> select();
        return [
            'page' => $params['page'],
            'pageSize' => $params['pageSize'],
            'countItems' => $count,
            'lists' => $lists,
            'countPage' => ceil($count / $params['pageSize']),
            'hasNext' => $params['page'] >= ceil($count / $params['pageSize']) ? false : true
        ];
    }
}