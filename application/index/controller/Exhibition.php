<?php


namespace app\index\controller;


use app\index\service\exhibition\ExhibitionService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\exhibition\ExhibitionValidate;
use think\facade\Request;
use library\helper\OutputHelper;

class Exhibition extends Base
{
    public function create()
    {
        ( new ExhibitionValidate() ) -> run();
        $params = [
            'act_name' => Request::post('act_name'),
            'act_start_time' => Request::post('act_start_time',0),
            'act_end_time' => Request::post('act_end_time',0),
            'act_range_time' => Request::post('act_range_time'),
            'thumb_img' => Request::post('thumb_img'),
            'content' => Request::post('content'),
//            'cat_id' => Request::post('cat_id'),
            'range_start' => Request::post('range_start'),
            'range_end' => Request::post('range_end'),
            'act_type' => Request::post('act_type'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionService() ) -> add($params);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new ExhibitionValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'act_name' => Request::post('act_name'),
            'act_start_time' => Request::post('act_start_time'),
            'act_end_time' => Request::post('act_end_time'),
            'act_range_time' => Request::post('act_range_time'),
            'thumb_img' => Request::post('thumb_img'),
            'content' => Request::post('content'),
            'cat_id' => Request::post('cat_id'),
            'range_start' => Request::post('range_start'),
            'range_end' => Request::post('range_end'),
            'act_type' => Request::post('act_type'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function category()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'actId' => Request::get('actId' , ''),
        ];
        $results = ( new ExhibitionService() ) -> otherCategory($params);
        OutputHelper::ajax($results);
    }

    public function allCategory()
    {
        $results = ( new ExhibitionService() ) -> allCategory();
        OutputHelper::ajax($results);
    }

    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'act_name' => Request::get('act_name'),
            'create_time' => Request::get('create_time'),
            'act_cat_id' => Request::get('act_cat_id'),
            'logic_status' => Request::get('logic_status'),
            'act_type' => Request::get('act_type'),
        ];
        $results = ( new ExhibitionService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new ExhibitionService() ) -> delete($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new ExhibitionService() ) -> operate($params);
        OutputHelper::ajax($results);
    }

}