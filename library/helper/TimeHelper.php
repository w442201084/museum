<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-02
 * Time: 10:42
 */

namespace library\helper;


class TimeHelper
{
    public static function getNowTime()
    {
        return date('Y-m-d H:i:s');
    }

    public static function format($time)
    {
        return date('Y-m-d H:i:s' , $time);
    }

    public static function formatYMD($time)
    {
        return date('Y-m-d' , $time);
    }

    public static function getBeginMonthDay()
    {
        return date('Y-m-01', strtotime(date("Y-m-d")));
    }

    public static function getNowBeginDay()
    {
        return date('Y-m-d '). '00:00:00';
    }
}