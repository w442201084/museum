<?php


namespace app\index\controller;


use app\index\service\ancient\AncientCategoryService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\ancient\AncientCategoryValidate;
use library\helper\OutputHelper;
use think\facade\Request;

class AncientCategory
{
    public function create()
    {
        ( new AncientCategoryValidate() ) -> run();
        $params = [
            'value' => Request::post('value'),
            'act_type' => Request::post('act_type'),
            'desc' => Request::post('desc'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new AncientCategoryService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new AncientCategoryValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'value' => Request::post('value'),
            'act_type' => Request::post('act_type'),
            'desc' => Request::post('desc'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new AncientCategoryService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new AncientCategoryService() ) -> delete($params);
        OutputHelper::ajax($results);
    }

    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'value' => Request::get('value'),
            'create_time' => Request::get('create_time'),
            'logic_status' => Request::get('logic_status'),
            'act_type' => Request::get('act_type'),
        ];
        $results = ( new AncientCategoryService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new AncientCategoryService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}