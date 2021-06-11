<?php


namespace app\api\controller;


use app\index\service\act\ActService;
use library\helper\OutputHelper;

class Act extends Base
{
    public function conf()
    {
        $apiResults = (new ActService()) -> conf();
        OutputHelper::ajax($apiResults);
    }
}