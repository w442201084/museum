<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/12/22
 * Time: 15:38
 */

namespace app\index\controller;

use app\index\service\exhibition\ExhibitionCategoryService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\exhibition\ExhibitionCategoryValidate;
use think\facade\Request;
use library\helper\OutputHelper;

class ExhibitionCategory extends Base
{
    public function create()
    {
        ( new ExhibitionCategoryValidate() ) -> run();
        $params = [
            'value' => Request::post('value'),
            'content' => Request::post('content'),
            'act_id' => Request::post('act_id'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionCategoryService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new ExhibitionCategoryValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'value' => Request::post('value'),
            'content' => Request::post('content'),
            'act_id' => Request::post('act_id'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionCategoryService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new ExhibitionCategoryService() ) -> delete($params);
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
            'act_id' => Request::get('act_id'),
            'logic_status' => Request::get('logic_status'),
        ];
        $results = ( new ExhibitionCategoryService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new ExhibitionCategoryService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}