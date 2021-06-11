<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function rand_str($randLength = 32)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQEST';
    $len = strlen($chars);
    $randStr = '';
    for ($i = 0; $i < $randLength; $i++) {
        $randStr .= $chars[mt_rand(0, $len - 1)];
    }
    return $randStr;
}

/**
 * @desc 输出树形结构
 * @param $data
 * @param string $uniqueKey
 * @param string $pidFieldKey
 * @return array
 */
function createTree($data , $uniqueKey = 'id' , $pidFieldKey = 'pid') {
    $tree = [];
    $res = array_column($data , null , $uniqueKey);
    if( !empty($res) ) {
        $keyExists = false;
        foreach ($res as $key => $vo) {
            if( $keyExists || array_key_exists($pidFieldKey , $vo) ) {
                $keyExists = true;
                $res[$vo[$pidFieldKey]]['children'][] = &$res[$key];
            }
        }
        foreach ($res as $key => $vo) {
            /** 剔除多余的分支节点(点不能成线) */
            if(isset($vo[$pidFieldKey]) && $vo[$pidFieldKey] == 0){
                $tree[] = $vo;
            }
        }
        return $tree;
    } else {
        return [];
    }
}

function filterEmoji($str)
{
    $str = preg_replace_callback( '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);
    return $str;
}

function clientIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}