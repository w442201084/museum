<?php


namespace app\index\controller;


use app\index\model\OtherConfigModel;
use app\index\model\TicketInfoModel;
use app\index\model\TicketPoolModel;
use app\index\service\msg\MsgService;
use app\index\service\ticket\TicketService;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use think\facade\Request;

class Tickets
{
    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'name' => Request::get('name'),
            'appointment_time' => Request::get('appointment_time'),
            'type' => Request::get('type'),
            'code' => Request::get('code'),
            'status' => Request::get('status'),
        ];
        $results = ( new TicketService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function get_config()
    {
        $row = TicketPoolModel::order('id' ,'desc') -> find();
        $results = [
            'code_ticket' => 0, // 身份证渠道票数
            'is_code' => 0, // 是否无线票数
            'is_code_borrow' => 0, // 是否允许向其它渠道借票
            'qr_code_ticket' => 0, // 公众号预约票数
            'is_qr_code' => 0, // 是否无线票数
            'is_qr_code_borrow' => 0 , // 是否允许向其它渠道借票,
            'ticket_not_allow' => ''
        ];
        if($row) {
            $results = $row -> toArray();
        }
        $config = OtherConfigModel::get(1);
        if($config) {
            $results['ticket_not_allow'] = json_decode($config -> ticket_not_allow , true);
        }
        OutputHelper::ajax($results);
    }

    public function save_config()
    {
        $params = [
            'code_ticket' => Request::get('code_ticket' , 0),
            'is_code' => Request::get('is_code' , 0),
            'is_code_borrow' => Request::get('is_code_borrow' , 0),
            'qr_code_ticket' => Request::get('qr_code_ticket' , 0),
            'is_qr_code' => Request::get('is_qr_code' , 0),
            'is_qr_code_borrow' => Request::get('is_qr_code_borrow' , 0),
        ];
        $results = ( new TicketService() ) -> saveConfig($params);
        OutputHelper::ajax($results);
    }

    public function add_tickets()
    {
        $params = [
            'logic_type' => Request::post('logic_type' , 1),
            'numbers' => Request::post('numbers' , 0),
        ];
        $results = ( new TicketService() ) -> addTickets($params);
        OutputHelper::ajax($results);
    }

    public function other_config()
    {
        $params = [
            'ticket_not_allow' => Request::post('ticket_not_allow' , ""),
        ];
        $results = ( new TicketService() ) -> setOtherConfig($params);
        OutputHelper::ajax($results);
    }
}