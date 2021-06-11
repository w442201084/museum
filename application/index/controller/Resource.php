<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 18:41
 */

namespace app\index\controller;


use app\index\service\img\ResourceService;
use library\helper\OutputHelper;

class Resource extends Base
{
    public function upload()
    {
        if( !empty($_FILES['file']) ){
            $handel = new ResourceService();
            $image = $handel -> upload($_FILES);
            OutputHelper::ajax($image);
        } else {
            OutputHelper::ajax(['msg' => '获取图片资源失败', 'data' => []] , 500);
        }
    }
}