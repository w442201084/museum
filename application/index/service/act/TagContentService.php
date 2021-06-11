<?php


namespace app\index\service\act;


use app\index\model\TagContentModel;
use app\index\service\cache\RedisHandle;
use library\exception\ParameterException;
use library\helper\ImgHelper;

class TagContentService
{
    public function save($params)
    {
        $model = new TagContentModel();
        $content = $model -> where("logic_type" , "=" , $params['logic_type']) -> find();
        $alias = [];
        if( !empty($content) ) {
            $alias['id'] = $content -> id;
        }
        $redisHandle = RedisHandle::getInstance();
        $cacheKey = 'desc:' . $params['logic_type'];
        $delStatus = $redisHandle -> delete($cacheKey); 
        $status = $model -> allowField(true) -> save($params , $alias);
        return $status;
    }

    public function detail($params)
    {
        $row = TagContentModel::where('logic_type' , '=' ,$params['logic_type']) -> find();
        if(empty($row)) {
            throw new ParameterException();
        } else {
            $row = $row -> toArray();
            return $row;
        }
    }
}