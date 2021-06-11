<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/25
 * Time: 15:51
 */

namespace library\helper;

class OutputHelper
{
    static public function format_return( $msg, $code = 500, $data = ''){
        $result = array(
            'code' => $code,
            'msg' => empty($msg) && isset($data['msg']) ?$data['msg']: $msg,
            'data' => $data
        );
        return $result;
    }

    public static function ajax( $data, $code = 0, $callback = '' ) {
        if( !empty($data['code']) ) {
            $code = $data['code'] ?? $code;
            $msg = !empty($data['msg']) ? $data['msg'] : '系统异常！';
            $data['code'] = $code;
            $data['msg'] = $msg;
        } else {
            $data = self::format_return('', $code, $data);
        }
        $data = json_encode($data);
        if( !empty($callback) )  {
            header("Content-Type:application/javascript; charset=utf-8");
            exit("{$callback}(".$data.")");
        } else {
            header('Content-Type:application/json; charset=utf-8');
            exit ($data);
        }
    }
}