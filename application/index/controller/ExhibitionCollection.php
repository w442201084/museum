<?php


namespace app\index\controller;

use app\index\model\ActCollectionDetailModel;
use app\index\service\exhibition\ExhibitionCollectionService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\exhibition\ExhibitionCollectionValidate;
use think\facade\Request;
use library\helper\OutputHelper;

class ExhibitionCollection extends Base
{
    public function create()
    {
        ( new ExhibitionCollectionValidate() ) -> run();
        $params = [
            'cat_id' => Request::post('cat_id'),
            'coll_name' => Request::post('coll_name'),
            'content' => Request::post('content'),
            'thumb_img' => Request::post('thumb_img'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionCollectionService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function detail()
    {
        ( new CheckIdInt() ) -> run();
        $id =  Request::get('id');
        $results = ActCollectionDetailModel::get($id);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new ExhibitionCollectionValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'cat_id' => Request::post('cat_id'),
            'coll_name' => Request::post('coll_name'),
            'content' => Request::post('content'),
            'thumb_img' => Request::post('thumb_img'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new ExhibitionCollectionService() ) -> update($params);
        OutputHelper::ajax($results);
    }

    public function lists()
    {
        ( new CheckPageInt() ) -> run();
        $params = [
            'page' => Request::get('page'),
            'pageSize' => Request::get('pageSize'),
            'coll_name' => Request::get('coll_name'),
            'create_time' => Request::get('create_time'),
            'cat_id' => Request::get('cat_id'),
            'logic_status' => Request::get('logic_status'),
        ];
        $results = ( new ExhibitionCollectionService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new ExhibitionCollectionService() ) -> delete($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new ExhibitionCollectionService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}