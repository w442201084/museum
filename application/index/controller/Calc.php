<?php


namespace app\index\controller;


use app\index\model\TicketInfoModel;
use app\index\service\cache\RedisHandle;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use library\helper\TimeHelper;
use library\helper\WhereHelper;
use think\Db;
use think\facade\Request;

class Calc
{
    public function user_nums()
    {
        $cacheKey = 'calc:join';
        $redis = RedisHandle::getInstance();
        if(!$results = $redis -> get($cacheKey)) {
            $totalCount = Db::query('select count(1) as totalCount from ticket_info');
            $totalCount = $totalCount[0]['totalCount'] ?? 0;
            $totalCountByMonth = Db::query(' select count(1) as totalCountByMonth from ticket_info where create_time > "'. TimeHelper::getBeginMonthDay() .'" ');
            $totalCountByMonth = $totalCountByMonth[0]['totalCountByMonth'] ?? 0;
            $totalCountByDay = Db::query(' select count(1) as totalCountByDay from ticket_info where appointment_time = "'. TimeHelper::formatYMD(time()) .'" ');
            $totalCountByDay = $totalCountByDay[0]['totalCountByDay'] ?? 0;
            $results = [
                'totalCount' => $totalCount,
                'totalCountByMonth' => $totalCountByMonth,
                'totalCountByDay' => $totalCountByDay,
            ];
            $redis -> set($cacheKey , $results , 300 + rand(10,100));
        }
        OutputHelper::ajax($results);
    }

    public function recent_ticket()
    {
        $model = new TicketInfoModel();
        $page = Request::get('page' , 1);
        $pageSize = Request::get('pageSize' , 7);
        (new CheckPageInt()) -> run();
        $cacheKey = 'calc:ticket' . $page .'-' . $pageSize;
        $redis = RedisHandle::getInstance();
        if( !$lists = $redis -> get($cacheKey) ) {
            $lists = $model -> lists([] , $page , $pageSize);
            if(!empty($lists['lists'])) {
                $lists['lists'] = array_map(function($row){
                    $row['typeAlias'] = $row['type'] == 1 ? '身份证取票' : '公众号预约';
                    $row['code'] = substr_replace($row['code'], '*********', 6, 9);
                    return $row;
                } , $lists['lists'] -> toArray());
                $redis -> set($cacheKey , $lists , 300 + rand(10,100));
            }
        }
        OutputHelper::ajax($lists);
    }

    public function age_range()
    {
        $sql = ' select concat(age - mod(age , 10) , "~" , age - mod(age , 10) + 9) as range_age , count( id ) as nums , (sex)  from ticket_info group by range_age , sex ';
        $redis = RedisHandle::getInstance();
        $cacheKey = 'calc:age';
        if( !$lists = $redis -> get($cacheKey) ) {
            $results = Db::query($sql);
            $man = $woman = 0;
            $tmpRange = $range = [];
            if(!empty($results)) { // 0:女 1:男
                foreach ( $results as $row ) {
                    if($row['sex'] == 1) {
                        $man += $row['nums'];
                    } else {
                        $woman += $row['nums'];
                    }
                    if(!isset($range[$row['range_age']])) {
                        $range[$row['range_age']] = 0;
                    }
                    $range[$row['range_age']] += $row['nums'];
                }
            }
            foreach ($range as $key =>  $row) {
                $tmpRange[] = [
                    'name' => $key,
                    'value' => $row,
                ];
            }
            $lists = [
                'man' => $man,
                'woman' => $woman ,
                'range' => $tmpRange
            ];
            $redis -> set($cacheKey , $lists , 300 + rand(10,100));
        }

        OutputHelper::ajax($lists);
    }

    public function verification()
    {
        $redis = RedisHandle::getInstance();
        $cacheKey = 'calc:verification';
        $nowDate = date('Y-m-d');
        $monthLastDate = date("Y-m-d", strtotime("-1 month"));
        $sql = " select status from ticket_info where appointment_time = '{$nowDate}' ";
        $results = Db::query($sql);
        $totalNums = $verNums = $monthBeforeTotalNums = $monthBeforeVerNums = 0;
        if( !empty($results) ) {
            $totalNums = count($results);
            foreach ($results as $v) {
                if( 1 == $v['status'] ) {
                    $verNums ++;
                }
            }
        }
        $sql = " select status from ticket_info where appointment_time = '{$monthLastDate}' ";
        $monthBefore = Db::query($sql);
        if( !empty($monthBefore) ) {
            $monthBeforeTotalNums = count($monthBefore);
            foreach ($monthBefore as $v) {
                if( 1 == $v['status'] ) {
                    $monthBeforeVerNums ++;
                }
            }
        }
        if( $monthBeforeTotalNums <= 0 ) {
            $joinPercent = 0;
        } else {
            $joinPercent = (( $totalNums - $monthBeforeTotalNums ) * 1000 / $monthBeforeTotalNums / 1000 ) * 100;
            ( -100 == $joinPercent ) && $joinPercent = 0;
        }

        if( $monthBeforeVerNums <= 0 ) {
            $verificationPercent = 0;
        } else {
            $verificationPercent = (( $verNums - $monthBeforeVerNums ) * 1000 / $monthBeforeVerNums / 1000 ) * 100;
            ( -100 == $verificationPercent ) && $verificationPercent = 0;
        }


        $lists = [
            'todayJoinNums' => $totalNums, // 今日预约总人数
            'todayVerificationNums' => $verNums, // 今日核销总人数
            'diffVerificationNums' => $totalNums - $verNums,  // 今日未核销总人数
            'monthBeforeJoinNums' => $monthBeforeTotalNums, // 上个月预总人数
            'monthBeforeVerificationNums' => $monthBeforeVerNums, // 上个月核销总
            'joinPercent' => sprintf('%.2f' , $joinPercent), // 预约百分比
            'verificationPercent' => sprintf('%.2f' , $verificationPercent),  // 核销百分比
        ];
        OutputHelper::ajax($lists);
    }

    public function range_city()
    {
        $redis = RedisHandle::getInstance();
        $cacheKey = 'calc:range_city';
        if( !$results = $redis -> get($cacheKey) ) {
            $sql = "  select count(1) as cityCount, city from ticket_info where city != '' group by city  order by cityCount DESC limit 5 ";
            $results = Db::query($sql);
            if( !empty($results) ) {
                $results = array_map(function($row){
                    return ['name' => $row['city'] , 'value' => $row['cityCount']];
                } , $results);
            }
            $redis -> set($cacheKey , $results , 300 + rand(10,100));
        }
        OutputHelper::ajax($results);
    }

    public function range_month()
    {
        $redis = RedisHandle::getInstance();
        $cacheKey = 'calc:range_month';
        if( !$results = $redis -> get($cacheKey) ) {
            $sql = "  select DATE_FORMAT(create_time , '%Y-%m') as formatDate , count(type) as countType , type from ticket_info group by type , formatDate; ";
            $results = Db::query($sql);
            if( !empty($results) ) {
                $temp = [];
                foreach ($results as $k => $v){
                    $temp[$v['type']][] = [
                        'name' => $v['formatDate'],
                        'value' => $v['countType'],
                    ];
                }
                $results =  $temp;
            }
            $redis -> set($cacheKey , $results , 300 + rand(10,100));
        }
        OutputHelper::ajax($results);
    }

    public function migrate()
    {
        $redis = RedisHandle::getInstance();
        $cacheKey = 'calc:migrate';
        if( !$apiResults = $redis -> get($cacheKey) ) {
            $sql = "select count(province) as countCity , province , lng , lat from ticket_info  group by province";
            $results = Db::query($sql);
            $apiResults = [
                'left' => "",
                'right' => "",
            ];
            $left = $right = [];
            if( !empty($results) ) {
                foreach ($results as $k => $v) {
                    if( !empty($v['province']) ) {
                        $left[] = [
                            $v['province'] => [
                                sprintf('%.4f', $v['lng']),
                                sprintf('%.4f', $v['lat']),
                            ]
                        ];
                        $right[] = [
                            "sw" => $v['province'] ,
                            "s1" => $v['countCity'] ,
                            "sn" => "湖南省"
                        ];
                    }
                }
                $apiResults['left'] = $left;
                $apiResults['right'] = $right;
            }
            $redis -> set($cacheKey , $apiResults , 7200);
        }
        OutputHelper::ajax($apiResults);

    }
}