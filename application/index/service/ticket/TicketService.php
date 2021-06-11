<?php


namespace app\index\service\ticket;


use app\index\model\OtherConfigModel;
use app\index\model\TicketInfoModel;
use app\index\service\cache\RedisHandle;
use library\exception\ParameterException;
use library\helper\WhereHelper;

class TicketService
{
    private $statusAlias = [
        0 => '未取票',
        1 => '已取票',
        2 => '已取消',
    ];

    public function lists($params)
    {
        $model = new TicketInfoModel();
        $where = WhereHelper::combineWhere($params);
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        if( !empty($lists['lists']) ) {
            $lists['lists'] = array_map(function($row){
                $row['statusAlias'] = $this -> statusAlias[$row['status']] ?? '-';
                $row['typeAlias'] = $row['type'] == 1 ? '身份证取票' : '公众号预约';
                return $row;
            } , $lists['lists'] -> toArray());
        }
        return $lists;
    }

    public function saveConfig($params)
    {
        $queueTicket = 'update_ticket_pool';
        $redisHandle = RedisHandle::getInstance();
        return $redisHandle -> lPush($queueTicket , json_encode([
            'code_ticket' => intval($params['code_ticket']),
            'is_code' => intval($params['is_code']),
            'is_code_borrow' => intval($params['is_code_borrow']),
            'qrcode_ticket' => intval($params['qr_code_ticket']),
            'is_qrcode' => intval($params['is_qr_code']),
            'is_qrcode_borrow' => intval($params['is_qr_code_borrow']),
        ]));
    }

    public function addTickets($params)
    {
        $queueTicket = 'add_ticket';
        $redisHandle = RedisHandle::getInstance();
        if($params['numbers'] <= 0) {
            throw new ParameterException('票数必需大于0', 200001);
        }
        $code = $qr_code = 0;
        if ( $params['logic_type'] == 1 ) {
            $code = intval($params['numbers']);
        } else {
            $qr_code = intval($params['numbers']);
        }
        return $redisHandle -> lPush($queueTicket , json_encode([
            'code' => $code,
            'qr_code' => $qr_code,
        ]));
    }

    public function setOtherConfig($params)
    {
        $model = new OtherConfigModel();
        $status = $model -> save([
            'ticket_not_allow' => ($params['ticket_not_allow'])
        ] , ['id' => 1]);
        return $status;
    }


}