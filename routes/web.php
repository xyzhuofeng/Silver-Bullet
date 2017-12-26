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
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class
])->group(function () {
    // 项目首页纯页面
    Route::get('project', 'ProjectController@index');
// 项目列表AJAX纯数据
    Route::get('project/list', 'ProjectController@projList');
// 创建和保存项目信息
    Route::post('project', 'ProjectController@save');
// 打开指定项目详情
    Route::get('project/{project_id}', 'ProjectController@read');
});

/**
 * TaskController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class
])->group(function () {
    // 任务面板首页
    Route::get('project/{project_id}/task', 'TaskController@index')->name('task/index');
    // 项目任务AJAX纯数据
    Route::get('project/{project_id}/task/my', 'TaskController@my')->name('task/my');
    // 创建任务
    Route::post('task', 'TaskController@save');
});

/**
 * FileController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class
])->group(function () {
    // 文件面板首页
    Route::get('project/{project_id}/file', 'FileController@index')->name('file/index');
    // 上传文件
    Route::post('project/{project_id}/file/upload', 'FileController@upload')->name('file/upload');
    // 删除文件
    Route::post('project/{project_id}/file/delete', 'FileController@delete')->name('file/delete');
    // 查看文件
    Route::get('project/{project_id}/file/view', 'FileController@view')->name('file/view');
    // 下载文件
    Route::get('project/{project_id}/file/download', 'FileController@download')->name('file/download');
    // 目录预览
    Route::post('project/{project_id}/file/previewDir', 'FileController@previewDir')->name('file/previewDir');
    // 获取目录树
    Route::get('project/{project_id}/file/tree', 'FileController@tree')->name('file/tree');
    // 创建目录
    Route::post('project/{project_id}/file/saveDir', 'FileController@saveDir')->name('file/saveDir');
    // 删除目录
    Route::post('project/{project_id}/file/deleteDir', 'FileController@deleteDir')->name('file/deleteDir');
});

/**
 * UserController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class
])->group(function () {
    // 个人中心
    Route::get('user', 'UserController@index');
});
