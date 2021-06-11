<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/13
 * Time: 14:55
 */

namespace app\index\service\menu;


use app\index\model\MenuModel;
use think\facade\Cache;

class MenuService
{
    protected $cacheKeyPre = 'menu:';

    public function getListByTypeId($typeId = 1)
    {
        $cacheKey = $this -> cacheKeyPre . $typeId;
        if( !$lists = Cache::get($cacheKey) ) {
            $lists = MenuModel::where("menu_type" , "=" , $typeId) -> all();
            $lists && $lists = $lists -> toArray();
            Cache::set($cacheKey , $lists , 3600);
        }
        return $lists;
    }
}