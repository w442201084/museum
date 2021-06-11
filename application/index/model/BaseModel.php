<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-08
 * Time: 13:48
 */

namespace app\index\model;



use think\Model;

class BaseModel extends Model
{
    public function lists($where , $page , $pageSize , $sortField = 'id' , $sortType = 'desc')
    {
        return $this ->pageLists($this , $where , $page , $pageSize , $sortField , $sortType);
    }

    public function pageLists(BaseModel $model , $where , $page , $pageSize , $sortFiled = 'id' , $sortType = 'desc')
    {
        $count = $model -> where($where) -> count();
        $lists = $model -> where($where) -> page($page , $pageSize) -> order($sortFiled , $sortType) -> select();
        return [
            'page' => $page,
            'pageSize' => $pageSize,
            'countItems' => $count,
            'lists' => $lists,
            'countPage' => ceil($count / $pageSize),
            'hasNext' => $page >= ceil($count / $pageSize) ? false : true
        ];
    }
}