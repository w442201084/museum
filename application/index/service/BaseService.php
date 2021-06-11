<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/13
 * Time: 10:32
 */

namespace app\index\service;



use app\index\model\OptLogModel;
use think\facade\Request;

class BaseService
{
    public function __construct($user) {
        foreach ($user as $k => $v) {
            $this -> {$k} = $v;
        }
    }

    public function optLog($data) {
        $logData = [
            'controller' => Request::instance()->controller(),
            'action' => Request::instance() -> action(),
            'logic_type' => $this -> logType,
            'opt_data' => json_encode($data),
            'opt_user_name' => $this -> real_name,
            'opt_user_login' => $this -> login_name,
        ];
        ( new OptLogModel() ) -> save($logData);
    }
}