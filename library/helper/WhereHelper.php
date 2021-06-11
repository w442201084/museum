<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 15:03
 */

namespace library\helper;


class WhereHelper
{
    public static function combineWhere($params)
    {
        $where = [];
        // 逻辑状态
        if( isset($params['openId']) && strlen($params['openId']) > 0) {
            $where[] = ['open_id' , '=' , $params['openId']];
        }
        if( isset($params['act_type']) && strlen($params['act_type']) > 0) {
            $where[] = ['act_type' , '=' , $params['act_type']];
        }
        if( isset($params['appointment_time']) && strlen($params['appointment_time']) > 0) {
            $where[] = ['appointment_time' , '=' , TimeHelper::formatYMD($params['appointment_time'] / 1000)];
        }
        if( isset($params['type']) && strlen($params['type']) > 0) {
            $where[] = ['type' , '=' , $params['type']];
        }
        if( isset($params['code']) && strlen($params['code']) > 0) {
            $where[] = ['code' , '=' , $params['code']];
        }
        if( isset($params['status']) && strlen($params['status']) > 0) {
            $where[] = ['status' , '=' , $params['status']];
        }
        if( isset($params['logic_status']) && strlen($params['logic_status']) > 0) {
            $where[] = ['logic_status' , '=' , $params['logic_status']];
        }
        if( isset($params['user_phone']) && strlen($params['user_phone']) > 0) {
            $where[] = ['user_phone' , '=' , $params['user_phone']];
        }
        if( isset($params['act_id']) && strlen($params['act_id']) > 0) {
            $where[] = ['act_id' , '=' , $params['act_id']];
        }
        if( isset($params['cat_id']) && strlen($params['cat_id']) > 0) {
            $where[] = ['cat_id' , '=' , $params['cat_id']];
        }
        if( isset($params['user_name']) && strlen($params['user_name']) > 0) {
            $where[] = ['user_name' , 'like' , '%'. ($params['user_name']) .'%'];
        }
        if( isset($params['value']) && strlen($params['value']) > 0) {
            $where[] = ['value' , 'like' , '%'. ($params['value']) .'%'];
        }
        if( isset($params['coll_name']) && strlen($params['coll_name']) > 0) {
            $where[] = ['coll_name' , 'like' , '%'. ($params['coll_name']) .'%'];
        }
        // 图文广告标题
        if( isset($params['act_name']) && strlen($params['act_name']) > 0) {
            $where[] = ['act_name' , 'like' , '%'. ($params['act_name']) .'%'];
        }
        // 图文广告类型
        if( isset($params['logic_type']) && strlen($params['logic_type']) > 0) {
            $where[] = ['logic_type' , '=' , $params['logic_type']];
        }
        // 案例分类
        if( isset($params['act_cat_id']) && strlen($params['act_cat_id']) > 0) {
            $where[] = ['cat_id' , 'like' , '%|' . $params['act_cat_id'] . '|%'];
        }
        // 案例所属学院
        if( isset($params['company_id']) && strlen($params['company_id']) > 0) {
            $where[] = ['company_id' , '=' , $params['company_id']];
        }
        // 创建人手机
        if( isset($params['c_usr_phone']) && strlen($params['c_usr_phone']) > 0) {
            $where[] = ['c_usr_phone' , '=' , $params['c_usr_phone'] ];
        }
        if( isset($params['user_no']) && strlen($params['user_no']) > 0) {
            $where[] = ['user_no' , '=' , $params['user_no'] ];
        }
        if( isset($params['user_id']) && strlen($params['user_id']) > 0) {
            $where[] = ['user_id' , '=' , $params['user_id'] ];
        }
        if( isset($params['c_usr_no']) && strlen($params['c_usr_no']) > 0) {
            $where[] = ['c_usr_no' , '=' , $params['c_usr_no'] ];
        }
        if( isset($params['c_usr_email']) && strlen($params['c_usr_email']) > 0) {
            $where[] = ['c_usr_email' , '=' , $params['c_usr_email'] ];
        }
        // 案例名称
        if( isset($params['casesName']) && strlen($params['casesName']) > 0) {
            $where[] = ['case_name' , 'like' , '%'. ($params['casesName']) .'%'];
        }
        // 创建人姓名
        if( isset($params['c_usr_name']) && strlen($params['c_usr_name']) > 0) {
            $where[] = ['c_usr_name' , 'like' , '%'. ($params['c_usr_name']) .'%'];
        }
        if( isset($params['name']) && strlen($params['name']) > 0) {
            $where[] = ['name' , 'like' , '%'. ($params['name']) .'%'];
        }
        // 学校id
        if( isset($params['college_id']) && strlen($params['college_id']) > 0) {
            $where[] = ['college_id' , '=' , $params['college_id'] ];
        }
        if( isset($params['email']) && strlen($params['email']) > 0) {
            $where[] = ['mail' , '=' , $params['email'] ];
        }
        if( isset($params['opt_user_name']) && strlen($params['opt_user_name']) > 0) {
            $where[] = ['opt_user_name' , '=' , $params['opt_user_name'] ];
        }

        // 创建时间
        if( isset($params['create_time']) && strlen($params['create_time']) > 0) {
            $createTime = date('Y-m-d H:i:s' , $params['create_time'] / 1000);
            $where[] = ['create_time' , '>' , $createTime];
        }
        return $where;
    }

}