<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------



Route::post('api/login', 'index/Login/index');
Route::post('api/logout', 'index/Login/logOut');
Route::get('api/captcha', 'index/Login/captcha');
Route::post('admin/chang_pwd', 'index/Users/changePwd');

Route::get('excel/upload', 'index/Excel/upload');

Route::post('img/upload', 'index/Img/upload');
Route::post('resource/upload', 'index/Resource/upload');




Route::get('role/add', 'index/UserRole/add');
Route::get('role/update', 'index/UserRole/update');
Route::get('role/delete', 'index/UserRole/delete');
Route::get('role/lists', 'index/UserRole/lists');


Route::post('role_node/add', 'index/RoleNode/add');
Route::post('role_node/update', 'index/RoleNode/update');
Route::post('role_node/delete', 'index/RoleNode/delete');
Route::get('role_node/lists', 'index/RoleNode/lists');

Route::get('appointment_act/lists', 'index/appointmentAct/lists');
Route::post('appointment_act/add', 'index/appointmentAct/add');
Route::post('appointment_act/update', 'index/appointmentAct/update');
Route::post('appointment_act/delete', 'index/appointmentAct/delete');


Route::post('other_config/save', 'index/otherConfig/save');
Route::get('other_config/detail', 'index/otherConfig/detail');


Route::get('tree/authority', 'index/Tree/authority');



//Route::post('act/appointment', 'index/Act/appointment');
//Route::get('act/conf', 'index/Act/conf');

Route::get('desc/info', 'api/Desc/info');
Route::get('users/ticket', 'api/Users/ticket');
Route::post('users/appointment', 'api/Users/appointment');
Route::get('act/conf', 'api/Act/conf');

Route::get('wechat/code' , 'index/WeChat/code');
Route::get('users/info', 'index/Users/info');

Route::get('test/wx', 'index/index/index');

return [

];
