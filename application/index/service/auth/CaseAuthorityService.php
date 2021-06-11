<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/13
 * Time: 10:28
 */

namespace app\index\service\auth;


use app\index\model\CasesAuthorityModel;
use app\index\model\OptLogModel;
use app\index\service\BaseService;
use app\index\service\menu\MenuService;
use app\index\validate\auth\CasesAuthorityValidate;
use library\exception\CasesAuthorityException;
use library\helper\WhereHelper;
use library\menu\CasesAuthorityMenu;
use library\menu\NodeTreeMenu;
use think\Db;

class CaseAuthorityService extends BaseService
{
    public $logType = 1;


    public function __construct($user) {
        parent::__construct($user);
    }

    public function lists($params)
    {
        /** 不属于超级管理员 */
        if( NodeTreeMenu::ADMIN_ROLE_NODE !=  $this -> role_id ) {
            if( $this -> college_id != 0 ) {
                $params['college_id'] = $this -> college_id;
            }
        }
//        $params['college_id'] = 1;
        $colleges = ( new MenuService() ) -> getListByTypeId(2);
        $colleges = array_column($colleges , null , 'menu_value');
        $lists = ( new CasesAuthorityModel() ) -> getLists($params);
        $lists['lists'] = array_map(function($row) use ($colleges) {
            $row['user_name'] = $row['belongs_user']['name'];
            $row['c_usr_email'] = $row['belongs_user']['mail'];
            $row['job_num'] = $row['belongs_user']['job_num'];
            $row['phone'] = $row['belongs_user']['phone'];
            $row['mail'] = $row['belongs_user']['mail'];
            $row['wechat'] = $row['belongs_user']['wechat'];
            $row['role_id'] = $row['belongs_user']['role_id'];
            $row['college_id'] = $row['belongs_user']['college_id'];
            $row['college_name'] = $colleges[$row['college_id']]['menu_name'] ?? '-';
            unset($row['belongs_user']);
            return $row;
        } , $lists['lists'] -> toArray());
        return $lists;
    }

    public function delete($params)
    {
        $row = CasesAuthorityModel::get($params['id']);
        if( empty($row) ) {
            throw new CasesAuthorityException();
        }
        $logicType = $row -> logic_type;
        $status = $row -> delete();
        if($status) {
            $this -> optLog([
                'user_ids' => [$row -> user_id],
                'logic_type' => $logicType
            ]);
        }
        return $status;
    }

    public function create($params)
    {
        ( new CasesAuthorityValidate() ) -> run();
//        $row = CasesAuthorityModel::where('user_id' , $params['user_id'])
//            -> where('logic_type' , $params['logic_type']) -> find();
//        if( $row ) {
//            throw new CasesAuthorityException('当前添加的操作人已经配置过案例的操作权限了' , 104003);
//        }
        $model = new CasesAuthorityModel();
        $userIds = explode(',' , $params['user_id']);
        $saveData = array_map(function ($userId) use ($params){
            return [
                'user_id' => $userId,
                'college_id' => $params['college_id'],
                'logic_type' => $params['logic_type'],
                'user_no' => $params['user_no'],
                'email' => $params['email'],
            ];
        } , $userIds);
        $status = $model -> allowField(true) -> saveAll($saveData);
        if( $status ) {
            $this -> optLog([
                'user_ids' => array_column($status -> toArray() , 'user_id'),
                'logic_type' => $params['logic_type']
            ]);
        }
        return $status;
    }

    public function record($params)
    {
        $model = new OptLogModel();
        $params['logic_type'] = $this -> logType;
        if( NodeTreeMenu::ADMIN_ROLE_NODE !=  $this -> role_id ) {
            $params['opt_user_login'] = $this -> login_name;
        }
        $where = WhereHelper::combineWhere($params);
        $lists = $model -> lists($where , $params['page'] , $params['pageSize']);
        $lists['lists'] = array_map(function($row){
            $user = json_decode($row['opt_data'] , true);
            $ids = $user['user_ids'] ? implode(',',$user['user_ids']) : '-';
            $tpl = sprintf(config('record.case_authority_tpl') , $row['create_time'] ,
                $row['opt_user_login'] , $ids,  CasesAuthorityMenu::OPT_LOG_ACTION_ALIAS[$row['action']] ?? '-' ,
                CasesAuthorityMenu::OPT_LOG_LOGIC_TYPE_ALIAS[$user['logic_type'] ?? '-'] ?? '-');
            return $tpl;
        } , $lists['lists'] -> toArray());
        return $lists;
    }

    /**
     * @desc 获取已经配置权限的用户IDS
     * @param $params
     * @return array
     */
    public function getOrgDataByAuthType($params)
    {
        $where = WhereHelper::combineWhere($params);
        $userIds = CasesAuthorityModel::where($where)
            -> column('user_id');
        return $userIds;
    }
}