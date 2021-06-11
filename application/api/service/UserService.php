<?php


namespace app\api\service;


use app\index\model\TicketInfoModel;
use library\exception\ParameterException;
use library\helper\WhereHelper;
use think\facade\Cache;

class UserService
{
    public function ticket($params)
    {
        $ticket = new TicketInfoModel();
        if( empty($params['openId']) ) {
            throw new ParameterException('网络异常，请稍后再试');
        }
        $cacheKey = 'user:ticket:' . md5($params['openId'] . ':' . $params['page'] . ':'. $params['pageSize']);
        if(1 || !$results = Cache::get($cacheKey)) {
            $where = WhereHelper::combineWhere($params);
            $results = $ticket -> lists($where , $params['page'] , $params['pageSize']);
            $refStatus = [ '未取票',  '已取票', '已取消' ];
            $now = time();
            $results['lists'] = array_map(function($row) use($refStatus , $now){
                $row['statusAlias'] = $refStatus[$row['status']];
                $endLastTime = strtotime($row['appointment_time'] . '23:59:59');
                if( $row['status'] == 0 && $now > $endLastTime ) {
                    $row['statusAlias'] = '已过期';
                }
                $row['code'] = substr_replace($row['code'], '*********', 6, 9);
                return $row;
            } , $results['lists'] -> toArray());
            Cache::set($cacheKey , $results , 2 * 60);
        }
        return $results;
    }
}