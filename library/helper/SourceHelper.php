<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/30
 * Time: 16:58
 */

namespace library\helper;


class SourceHelper
{
    public static function addHost($imgName)
    {
        return config('common.resource_prefix') . DIRECTORY_SEPARATOR . trim($imgName);
    }
}