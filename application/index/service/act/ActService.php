<?php


namespace app\index\service\act;


use access\lib\common\Common;
use app\index\model\OtherConfigModel;
use app\index\service\wechat\WeChatService;
use app\index\validate\act\AppointmentValidate;
use library\exception\DbRunTimeException;
use library\exception\ParameterException;
use library\helper\TimeHelper;
use think\Exception;

class ActService
{
    public function appointment($params)
    {
        if( empty($params['openId']) ) {
            throw new ParameterException('获取openId失败' , 100001);
        }
        if( empty($params['tickets']) ) {
            throw new ParameterException('获取预约信息失败' , 100002);
        }
        $tickets = json_decode($params['tickets'] , true);
        $validate = new AppointmentValidate();

        $wechat = new WeChatService();
        $userInfo = $wechat -> getUserInfo($params['openId']);
        if( empty($userInfo) ) {
            throw new ParameterException('网络开小差了，请稍后再试');
        }
        foreach ( $tickets as $k => $ticket ) {
            $tickets[$k]['openId'] = $params['openId'];
            $tickets[$k]['nickname'] = filterEmoji($userInfo['nickname']) ?? '';
            $validate -> vaildate($tickets[$k]);
        }
        $msg = [];
        $common = new Common();
        foreach ( $tickets as $k => $ticket ) {
            $apiParams = [
                'name' => $ticket['realName'],
                'code' => $ticket['idCard'],
                'appointment_data' => $ticket['date'],
                'children' => $ticket['children'],
                'phone' => $ticket['realPhone'],
                'nick_name' => $ticket['nickname'],
                'open_id' => $ticket['openId'],
            ];
            $apiResults = $this -> apiCreateTickets($apiParams , $common);
            if( empty($apiResults) ) {
                throw new DbRunTimeException('网络超时了，请稍后再试');
            }
            if( $apiResults['code'] != 0 ) {
                if( $apiResults['code'] == 10002 ) {
                    $tips = $ticket['realName']. ':' . '抱歉,系统开小差啦! 请重试';
                } else {
                    $tips = $ticket['realName']. ':' . $apiResults['msg'];
                }
                $msg[] = [
                    'msg' => $tips,
                    'code' => 100004
                ];
            } else {
                $msg[] = [
                    'msg' => $ticket['realName']. ':' . '预约成功',
                    'code' => 0
                ];
                // 发送消息模板
                $wechat -> sendMsg($ticket['openId'] , [
                    'keyword1' => $apiResults['data']['phone'],
                    'keyword2' => $apiResults['data']['code'],
                    'keyword3' => $apiResults['data']['time'],
                    'keyword4' => '9:00~11:30',
                    'keyword5' => $apiResults['data']['people_num'],
                    'remark' => '切记进馆需要携带身份证及当前手机进行现场验证',
                ]);
            }
        }
        return $msg;
    }

    /**
     * @desc 发票
     * @param $apiResults
     * @param $common
     * @return mixed
     */
    public function apiCreateTickets($apiResults , $common)
    {
        $header = [
            'X-real-ip' => clientIP(),
        ];
        $apiHost = config('common.app_host') . '/api/appointment/qr_code';
        $apiResults = $common -> httpRequest($apiHost , 'post' , $apiResults , $header);
        $apiResults = (json_decode($apiResults , true));
        return $apiResults;
    }

    public function conf()
    {
        $now = time();
        $data = [];
        for($i = 0; $i<= 7; $i++) {
            $data[] = date("Y-m-d", strtotime("+{$i} day", $now));
        }
        $row = OtherConfigModel::get(1);
        if( !empty($row) ) {
            if(!empty($row['ticket_not_allow'])) {
                $notAllow = json_decode($row['ticket_not_allow'] , true);
                $data = array_values(array_diff($data , $notAllow));
            }
        }
        return ['own_select_date' => $data];
    }

}