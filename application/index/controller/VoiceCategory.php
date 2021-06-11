<?php


namespace app\index\controller;


use app\index\service\voice\VoiceCategoryService;
use app\index\validate\voice\VoiceCategoryValidate;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use library\helper\OutputHelper;
use think\facade\Request;

class VoiceCategory
{
    public function create()
    {
        ( new VoiceCategoryValidate() ) -> run();
        $params = [
            'value' => Request::post('value'),
            'desc' => Request::post('desc'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new VoiceCategoryService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new VoiceCategoryValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'value' => Request::post('value'),
            'desc' => Request::post('desc'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new VoiceCategoryService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new VoiceCategoryService() ) -> delete($params);
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
        ];
        $results = ( new VoiceCategoryService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new VoiceCategoryService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}