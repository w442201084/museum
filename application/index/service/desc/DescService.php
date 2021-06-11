<?php


namespace app\index\service\desc;


use app\index\model\TagContentModel;
use app\index\service\cache\RedisHandle;
use library\exception\ParameterException;
use think\facade\Cache;

class DescService
{
    public function getInfo($params)
    {
        $redisHandle = RedisHandle::getInstance();
        $logicType = $params['logic_type'];
        if( empty($logicType)) {
            throw new ParameterException('获取类型失败');
        }
        $cacheKey = 'desc:' . $logicType;
        if( !$info = $redisHandle -> get($cacheKey) ) {
            $model = new TagContentModel();
            $info = $model -> where("logic_type",$logicType) -> find();
            if($info) {
                $info = $info -> toArray();
                $redisHandle -> set($cacheKey , $info , 7200);
            }
        }
        return $info;
    }
}