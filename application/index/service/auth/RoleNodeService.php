<?php
/**
 * Created by PhpStorm.
 * User: ghost
 * Date: 2020-10-26
 * Time: 21:53
 */

namespace app\index\service\auth;


use app\index\controller\RoleNode;
use app\index\model\RoleModel;
use app\index\model\RoleNodeModel;
use app\index\service\BaseService;
use app\index\validate\auth\RoleNodeValidate;
use library\exception\RoleException;
use library\exception\RoleNodeException;
use library\helper\TimeHelper;
use think\facade\Cache;
use library\menu\NodeTreeMenu;

class RoleNodeService extends BaseService
{
    public function __construct($user)
    {
        parent::__construct($user);
    }

    /** 完整树缓存key */
    private $cacheNodeTree = 'node:all';
    private $cacheNodeTime = 3600 * 24;


    public function add($params)
    {
        ( new RoleNodeValidate() ) -> run();
        $model = new RoleNodeModel();
        $params['create_time'] = TimeHelper::getNowTime();
        $status = $model -> allowField(true) -> save($params);
        return $status;
    }

    public function update($params)
    {
        ( new RoleNodeValidate() ) -> run();
        $node = RoleNodeModel::get($params['id']);
        if( empty($node) ) {
            throw new RoleNodeException();
        } else {
            $node = $node -> toArray();
            if( $node['pid'] != $params['pid'] ) {
                // 查询当前节点是否挂了子节点
                $childNodes = RoleNodeModel::where('pid' , '=' , $node['id']) -> select();
                if(!empty($childNodes -> toArray())) {
                    throw new RoleNodeException('当前节点存在子节点' , 100502);
                } else {
                    if(0 != $params['pid']) {
                        // 查询当前更新节点的父节点对应的level是不是等于当前节点level+1
                        $parentNode = RoleNodeModel::get($params['pid']);
                        if( empty($parentNode) ) {
                            new RoleNodeException('查询节点失败',100501);
                        } else {
                            $parentNode = $parentNode -> toArray();
                            if( $parentNode['logic_level'] != ( intval($params['logic_level']) + 1 ) ) {
                                throw new RoleNodeException('节点层级更新异常' , 100503);
                            }
                        }
                    }
                }
            } else {
                if( $node['logic_level'] != $params['logic_level'] ) {
                    throw new RoleNodeException('节点层级更新异常' , 100503);
                } 
            }
        }
        $model = new RoleNodeModel();
        $status = $model -> allowField(true) -> save($params , ['id' => $params['id']]);
        return $status;
    }

    public function delete($params)
    {
        $node = RoleNodeModel::get($params['id']);
        if( empty($node) ) {
            throw new RoleNodeException();
        } else {
            $model = new RoleNodeModel();
            $status = $model -> allowField(true) -> save(['logic_delete' => 1] , ['id' => $params['id']]);
            return $status;
        }
    }

    public function lists($params , $type = true)
    {
        $pid = $params['pid'] ?? 0;
        $level = $params['logic_level'] ?? 3;
        $where[] = ['logic_delete' , '=' , 0];
        if( $this -> role_id != NodeTreeMenu::ADMIN_ROLE_NODE ) {
            $roleRow = RoleModel::get($this -> role_id);
            if( empty($roleRow) ) {
                throw new RoleException();
            }
            $nodeIds = explode(',' , $roleRow -> role_nodes);
            $where[] = ['id' , 'in' , $nodeIds ];
        }
        $nodeLists = RoleNodeModel::where($where) ->
            order('logic_sort' , 'asc') -> select();
        $nodeLists && $nodeLists = $nodeLists -> toArray();
        $cacheKey = $this -> cacheNodeTree . ':' . $pid . ':' . $level . ':' . $type? 1:0;
        if( 1 || !$lists = Cache::get($cacheKey) ) {
            if( $type ) {
                $lists = $this -> tree($nodeLists , $pid , $level);
            } else {
                $lists = $nodeLists;
            }
            Cache::set($cacheKey , $lists , $this -> cacheNodeTime);
        }
        return $lists;
    }

    public function tree($nodeLists , $pid , $level)
    {
        $child = [];
        foreach ($nodeLists as $key => $category)
        {
            if( $pid == $category['pid'] && $category['logic_level'] <= $level ){
                $category['child'] = $this -> tree($nodeLists, $category['id'] , $level);
                $child[] = $category;
            }
        }
        return $child;

    }

}