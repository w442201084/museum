<?php


namespace app\index\validate\appointment;


use app\index\validate\BaseValidate;

class AppointmentActValidate extends BaseValidate
{
    public $code = 100600;

    protected $rule = [
        'act_name' => 'require|max:60',
        'act_start_time' => 'require|date',
        'act_end_time' => 'require|date',
        'allow_start_time' => 'require|date',
        'allow_end_time' => 'require|date',
        'chair_man' => 'require|max:10',
        'act_address' => 'require|max:50',
    ];

    protected $message = [
        'act_name.require' => '活动名称不能为空',
        'act_name.max' => '活动名称最大长度不能超过60个字符',
        'act_start_time.require' => '活动开始时间不能为空',
        'act_start_time.date' => '活动开始时间格式有误',
        'act_end_time.require' => '活动截止时间不能为空',
        'act_end_time.date' => '活动截止时间格式有误',
        'allow_start_time.require' => '允许开始时间格式有误',
        'allow_start_time.date' => '允许开始时间格式有误',
        'allow_end_time.require' => '允许截止时间格式有误',
        'allow_end_time.date' => '允许截止时间格式有误',
        'chair_man.require' => '主持人姓名不能为空',
        'chair_man.max' => '主持人姓名最大长度不能超过10个字符',
        'act_address.require' => '活动地址不能为空',
        'act_address.max' => '活动地址最大长度不能超过50个字符',
    ];
}