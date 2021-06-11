<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-08
 * Time: 14:14
 */

namespace app\index\controller;

use app\index\service\excel\ExcelService;
use app\index\service\excel\ExcelTool;
use think\facade\Request;

/**
 * @desc EXCEL导入导出控制
 * Class Excel
 * @package app\index\controller
 */
class Excel extends Base
{
    // composer require phpoffice/phpspreadsheet
    /**
     * @desc 模板下载
     */
    public function upload()
    {
        $mark = Request::get('mark');
        $excel = new ExcelService();
        $excel -> downloadTpl($mark);
    }

    /**
     * @desc 模板数据解析
     */
    public function parse()
    {

    }
}