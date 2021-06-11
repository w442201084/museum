<?php


namespace app\index\controller;

use app\index\model\VoiceCollectionDetailModel;
use app\index\service\voice\VoiceCollectionService;
use app\index\validate\CheckIdInt;
use app\index\validate\CheckPageInt;
use app\index\validate\voice\VoiceCollectionValidate;
use think\facade\Request;
use library\helper\OutputHelper;

class VoiceCollection extends Base
{
    public function create()
    {
        ( new VoiceCollectionValidate() ) -> run();
        $params = [
            'cat_id' => Request::post('cat_id'),
            'coll_name' => Request::post('coll_name'),
            'content' => Request::post('content'),
            'thumb_img' => Request::post('thumb_img'),
            'voice_source' => Request::post('voice_source'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new VoiceCollectionService() ) -> create($params);
        OutputHelper::ajax($results);
    }

    public function detail()
    {
        ( new CheckIdInt() ) -> run();
        $id =  Request::get('id');
        $results = VoiceCollectionDetailModel::get($id);
        OutputHelper::ajax($results);
    }

    public function update()
    {
        ( new CheckIdInt() ) -> run();
        ( new VoiceCollectionValidate() ) -> run();
        $params = [
            'id' => Request::post('id'),
            'cat_id' => Request::post('cat_id'),
            'coll_name' => Request::post('coll_name'),
            'content' => Request::post('content'),
            'thumb_img' => Request::post('thumb_img'),
            'voice_source' => Request::post('voice_source'),
            'logic_sort' => Request::post('logic_sort' , 10),
        ];
        $results = ( new VoiceCollectionService() ) -> update($params);
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
        $results = ( new VoiceCollectionService() ) -> lists($params);
        OutputHelper::ajax($results);
    }

    public function delete()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id')
        ];
        $results = ( new VoiceCollectionService() ) -> delete($params);
        OutputHelper::ajax($results);
    }

    public function operate()
    {
        ( new CheckIdInt() ) -> run();
        $params = [
            'id' => Request::get('id'),
            'logic_status' => Request::get('logic_status' , 1),
        ];
        $results = ( new VoiceCollectionService() ) -> operate($params);
        OutputHelper::ajax($results);
    }
}