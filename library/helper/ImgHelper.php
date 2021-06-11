<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/30
 * Time: 16:58
 */

namespace library\helper;


class ImgHelper
{
    public static function addHost($imgName)
    {
        return config('common.img_prefix') . DIRECTORY_SEPARATOR . trim($imgName);
    }
}