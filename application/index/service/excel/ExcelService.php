<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/10
 * Time: 14:15
 */

namespace app\index\service\excel;


use library\exception\ExcelException;

class ExcelService
{
    public function downloadTpl($mark)
    {
        $excel = new ExcelTool();
        $fileName = '';
        $title = [];
        switch ($mark)
        {
            case 'users' :
                $title = [
                    ['真实姓名','工号/学号','手机号','邮箱','微信号','身份类型(学生:1 老师:2 专家:3)'],
                ];
                $fileName = '后台登陆用户导入模板';
                break;
        }
        if( !empty($title) ) {
            $excel -> exportExcel($title, $fileName . '.xlsx');
        } else {
            throw new ExcelException();
        }
    }
}