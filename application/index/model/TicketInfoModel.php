<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/25
 * Time: 14:21
 */

namespace app\index\model;


class TicketInfoModel extends BaseModel
{
    protected $table = 'ticket_info';

    protected $hidden = [
        'id',
        'create_time',
//        'type',
    ];

}