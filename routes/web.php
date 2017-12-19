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

/**
 * TaskController
 */
// 任务面板首页
Route::get('project/{project_id}/task', 'TaskController@index')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('task/index');
// 项目任务AJAX纯数据
Route::get('project/{project_id}/task/my', 'TaskController@my')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('task/my');
// 创建任务
Route::post('task', 'TaskController@save')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);

/**
 * FileController
 */
// 文件面板首页
Route::get('project/{project_id}/file', 'FileController@index')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/index');
// 上传文件
Route::post('project/{project_id}/file/upload', 'FileController@upload')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/upload');
// 删除文件
Route::post('project/{project_id}/file/delete', 'FileController@delete')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/delete');
// 目录预览
Route::post('project/{project_id}/file/previewDir', 'FileController@previewDir')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/previewDir');
// 获取目录树
Route::get('project/{project_id}/file/tree', 'FileController@tree')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/tree');
// 创建目录
Route::post('project/{project_id}/file/saveDir', 'FileController@saveDir')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/saveDir');
// 删除目录
Route::post('project/{project_id}/file/delDir', 'FileController@delDir')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class)
    ->name('file/delDir');
