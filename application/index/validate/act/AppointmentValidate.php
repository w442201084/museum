<?php


namespace app\index\validate\act;


use app\index\validate\BaseValidate;
use mysql_xdevapi\BaseResult;

class AppointmentValidate extends BaseValidate
{
    public $code = 100600;

    protected $rule = [
        'realName' => 'require|max:10',
        'idCard' => 'require|checkIdCard',
        'date' => 'require|date',
        'children' => 'require|between:0,3',
        'realPhone' => 'require|mobile',
        'openId' => 'require',
    ];

    public function checkIdCard($value)
    {
        return strlen($value) == 18;
    }

    protected $message = [
        'realName.require' => '真实姓名不能为空',
        'idCard.require' => '身份证号码不能为空',
        'idCard.checkIdCard' => '身份证号码长度必需为18位',
        'date.require' => '日期不能为空',
        'date.date' => '日期格式有误',
        'realName.max' => '真实姓名最大长度不能超过10个字',
        'children.require' => '携带小孩数量不能为空',
        'children.between' => '携带小孩数量不能超过3个小孩',
        'realPhone.require' => '电话号码不能为空',
        'realPhone.mobile' => '电话号码长度必需为11位',
        'openId.require' => '获取openId失败',
    ];
}