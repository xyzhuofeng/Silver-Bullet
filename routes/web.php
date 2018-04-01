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
 * PassportController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 修改密码
    Route::post('passport/updatePassword', 'PassportController@updatePassword');
    // 修改职位
    Route::post('passport/updateJob', 'PassportController@updateJob');
    // 修改姓名
    Route::post('passport/updateName', 'PassportController@updateName');
    // 修改头像
    Route::post('passport/updateAvatar', 'PassportController@updateAvatar');
});

/**
 * ProjectController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 项目首页纯页面
    Route::get('project', 'ProjectController@index');
    // 项目列表AJAX纯数据
    Route::get('project/list', 'ProjectController@projList');
    // 创建和保存项目信息
    Route::post('project', 'ProjectController@save');
    // 打开指定项目详情
    Route::get('project/{project_id}', 'ProjectController@read');
    // 打开指定项目的设置页面
    Route::get('project/{project_id}/setting', 'ProjectController@setting')->name('project/setting');
    // 更新封面图
    Route::post('project/{project_id}/updateThumb', 'ProjectController@updateThumb')->name('project/updateThumb');
    // 更新项目名称和描述
    Route::post('project/{project_id}/updateNameAndCommentUrl', 'ProjectController@updateNameAndCommentUrl')->name('project/updateNameAndCommentUrl');
    // 删除项目
    Route::get('project/{project_id}/delete', 'ProjectController@delete')->name('project/delete');
    // 获取git数据
    Route::get('project/{project_id}/git', 'ProjectController@git')->name('project/git');
    // 获取项目动态
    Route::get('project/{project_id}/timeline', 'ProjectController@timeline')->name('project/timeline');
    // 绑定github
    Route::post('project/{project_id}/github', 'ProjectController@github')->name('project/github');

});

/**
 * Wikicontroller
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 项目Wiki首页
    Route::get('project/{project_id}/wiki', 'WikiController@index')->name('wiki/index');
    // 获取wiki
    Route::get('project/{project_id}/wiki/article', 'WikiController@article')->name('wiki/article');
    // 保存wiki
    Route::post('project/{project_id}/wiki/save', 'WikiController@save')->name('wiki/save');
});

/**
 * MemberController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 打开指定项目的成员列表，AJAX数据
    Route::get('project/{project_id}/member', 'MemberController@index')->name('member/index');
    // 创建邀请码
    Route::get('project/{project_id}/member/genInviteCode', 'MemberController@genInviteCode')->name('member/genInviteCode');
    // 邀请链接
    Route::get('invite/{code}', 'MemberController@invite')->name('member/invite');
    // 成员移出项目
    Route::post('project/{project_id}/member/remove', 'MemberController@remove')->name('member/remove');
});

/**
 * TaskController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 任务面板首页
    Route::get('project/{project_id}/task', 'TaskController@index')->name('task/index');
    // 项目任务AJAX纯数据
    Route::get('project/{project_id}/task/my', 'TaskController@my')->name('task/my');
    // 项目未完成的任务
    Route::get('project/{project_id}/task/unfinish', 'TaskController@unfinish')->name('task/unfinish');
    // 创建任务
    Route::post('project/{project_id}/task/save', 'TaskController@save')->name('task/save');
    // 标记完成任务
    Route::post('project/{project_id}/task/finish', 'TaskController@finish')->name('task/finish');
    // 删除任务
    Route::post('project/{project_id}/task/delete', 'TaskController@delete')->name('task/delete');
});

/**
 * FileController
 */
Route::middleware([
    \App\Http\Middleware\CheckLoginStatus::class,
    \App\Http\Middleware\ViewTempleteVal::class,
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
    \App\Http\Middleware\ViewTempleteVal::class,
])->group(function () {
    // 个人中心
    Route::get('user', 'UserController@index');
});
