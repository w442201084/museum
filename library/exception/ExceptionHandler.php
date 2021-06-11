<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/8/7
 * Time: 14:20
 */

namespace library\exception;


use think\exception\Handle;
use think\Request;

class ExceptionHandler extends Handle
{
    private $httpCode;

    private $msg;

    private $code;

    public function render(\Exception $e) {
        if ( $e instanceof BaseException)  {
            $this -> httpCode = 200 ?? $e -> getHttpCode();
            $this -> msg = $e -> msg;
            $this -> code = $e -> code;
        } else {
            $this -> httpCode = 500;
            $this -> msg = ' Server error ' . $e -> getMessage();
            $this -> code = -400;
        }

        $results = [
            'code' => $this -> code ,
            'msg' => $this -> msg ,
            'url' => ( new Request() ) -> url()
        ];
        return json($results , $this -> httpCode);
    }
}