<?php


namespace app\index\validate\exhibition;


use app\index\validate\BaseValidate;

class ExhibitionValidate extends BaseValidate
{
    public $code = 100005;

    protected $rule = [
        'act_name' => 'require|max:50',
//        'act_start_time' => 'require|timeStamp',
//        'act_end_time' => 'require|timeStamp',
        'thumb_img' => 'require',
        'content' => 'require',
        'range_start' => 'require',
        'range_end' => 'require',
        'act_type' => 'require',
    ];

    protected $message = [
        'act_name.require' => '展览名称不能为空',
        'act_name.max' => '展览名称最大长度为50',
        'act_end_time.require' => '活动截止时间不能为空',
        'act_end_time.timeStamp' => '活动截止时间日期格式有误',
        'act_start_time.require' => '活动开始时间不能为空',
        'act_start_time.timeStamp' => '活动开始时间日期格式有误',
        'thumb_img.require' => '主图不能为空',
        'content.require' => '内容描述不能为空',
        'range_start.require' => '活动展出开始时间不能为空',
        'range_end.require' => '活动展出截止时间不能为空',
        'act_type.require' => '活动类型不能为空',
    ];
}