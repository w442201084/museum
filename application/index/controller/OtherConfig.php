<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 11/24/20
 * Time: 7:33 PM
 */

namespace app\index\controller;
use app\index\model\OtherConfigModel;
use app\index\validate\CheckIdInt;
use library\exception\BaseException;
use library\helper\TimeHelper;
use think\facade\Request;
use library\helper\OutputHelper;


class OtherConfig extends Base
{
    public function detail()
    {
        $row = OtherConfigModel::get(1);
        if( $row ) {
            $row = $row -> toArray();
            $row['case_effect_start_time'] &&
                $row['case_effect_start_time'] = strtotime($row['case_effect_start_time']);
            $row['case_effect_end_time'] &&
                $row['case_effect_end_time'] = strtotime($row['case_effect_end_time']);
        }
        OutputHelper::ajax($row);
    }

    public function save()
    {
        $case_effect_start_time = Request::post('case_effect_start_time');
        $case_effect_end_time = Request::post('case_effect_end_time');
        $model = new OtherConfigModel();
        $status = $model -> save([
            'case_effect_start_time' => TimeHelper::format($case_effect_start_time),
            'case_effect_end_time' => TimeHelper::format($case_effect_end_time),
        ] , ['id' => 1]);
        OutputHelper::ajax($status);
    }
}