<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-08
 * Time: 14:30
 */

namespace library\helper;

/**
 * @desc 请求参数防SQL注入
 * Class RequestFilter
 * @package library\helper
 */
class RequestFilter
{
    public static function filter($value)
    {
//        $keyword = '"|~|!|@|#|$|^|&|*|>|<|=| |%|sleep|select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile';
        $keyword = 'sleep|select|insert|update|delete|union|into|load_file|outfile';
        $arr = explode( '|', $keyword );
        $result = str_ireplace( $arr, '', $value );
        return $result;
    }
}