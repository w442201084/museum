<?php


namespace app\index\controller;


use app\index\service\appointment\AppointmentActService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\appointment\AppointmentActValidate;
use library\helper\OutputHelper;
use think\facade\Request;

class AppointmentAct
{
    public function create()
    {
        ( new AppointmentActValidate() ) -> run();
        $params = [
            'act_name' => Request::post('act_name'),
            'act_start_time' => Request::post('act_start_time'),
            'act_end_time' => Request::post('act_end_time'),
            'chair_man' => Request::post('chair_man'),
            'act_address' => Request::post('act_address'),
            'act_desc' => Request::post('act_desc'),
            'allow_start_time' => Request::post('allow_start_time'),
            'allow_end_time' => Request::post('allow_end_time'),
        ];
        $results = ( new AppointmentActService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new AppointmentActValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'act_name' => Request::post('act_name'),
            'act_start_time' => Request::post('act_start_time'),
            'act_end_time' => Request::post('act_end_time'),
            'chair_man' => Request::post('chair_man'),
            'act_address' => Request::post('act_address'),
            'act_desc' => Request::post('act_desc'),
            'allow_start_time' => Request::post('allow_start_time'),
            'allow_end_time' => Request::post('allow_end_time'),
        ];
        $results = ( new AppointmentActService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new AppointmentActService() ) -> delete($params);
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
        $results = ( new AppointmentActService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new AppointmentActService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}