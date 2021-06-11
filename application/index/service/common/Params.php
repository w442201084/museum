<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:30
 */

namespace app\index\service\common;


use think\Request;

class Params
{
    public static function getAll()
    {
        $request = ( new Request() );
        return array_merge( $request -> get() , $request -> post() );
    }
}