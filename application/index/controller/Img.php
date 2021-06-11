<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 18:41
 */

namespace app\index\controller;


use app\index\service\img\ImgService;
use library\helper\OutputHelper;

class Img extends Base
{
    public function upload()
    {
        if( !empty($_FILES['file']) ){
            $handel = new ImgService();
            $image = $handel -> upload($_FILES);
            OutputHelper::ajax($image);
        } else {
            OutputHelper::ajax(['msg' => '获取图片资源失败', 'data' => []] , 500);
        }
    }
}