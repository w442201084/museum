<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/28
 * Time: 10:53
 */

namespace app\index\controller;
use app\index\model\MenuModel;
use app\index\validate\CheckEnumType;
use library\menu\NodeTreeMenu;
use think\facade\Request;
use library\helper\OutputHelper;

class Menu extends Base
{
    public function lists()
    {
        ( new CheckEnumType() ) -> run();
        $menuType = Request::get('menu_type');
        $lists = MenuModel::where("menu_type" , "=" , $menuType) -> all();
        OutputHelper::ajax($lists);
    }
}