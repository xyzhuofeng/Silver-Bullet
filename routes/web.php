<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


use Illuminate\Support\Facades\Route;

/**
 * IndexController
 */
// 首页
Route::get('/', 'IndexController@index');

/**
 * PassportController
 */
// 注册登录页面
Route::get('passport', 'PassportController@index');
Route::get('passport/index', 'PassportController@index');
// 提交登录表单
Route::post('passport/login', 'PassportController@login');
// 提交注册表单
Route::post('passport/register', 'PassportController@register');
// 退出登录
Route::get('passport/logout', 'PassportController@logout');


/**
 * ProjectController
 */
// 项目首页纯页面
Route::get('project', 'ProjectController@index')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);
// 项目列表AJAX纯数据
Route::get('project/list', 'ProjectController@projList')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);
// 创建和保存项目信息
Route::post('project', 'ProjectController@save')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);
// 打开指定项目详情
Route::get('project/{project_id}', 'ProjectController@read')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);

