<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 13:55
 */

namespace app\index\controller;
use app\index\service\act\TagContentService;
use app\index\validate\act\TagContentValidate;
use app\index\validate\CheckIdInt;
use think\facade\Request;
use library\helper\OutputHelper;


/**
 * @desc 单类型图片广告
 * Class UniqueAd
 * @package app\index\controller
 */
class TagContent extends Base
{
    public function save()
    {
        ( new TagContentValidate() ) -> run();
        $params = [
            'content' => Request::post('content'),
            'logic_type' => Request::post('logic_type'),
        ];
        $results = ( new TagContentService() ) -> save($params);
        OutputHelper::ajax($results);
    }

    public function detail()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'logic_type' => Request::get('id'),
        ];
        $results = ( new TagContentService() ) -> detail($params);
        OutputHelper::ajax($results);
    }
}