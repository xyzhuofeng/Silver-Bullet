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

// 首页
Route::get('/', 'IndexController@index');
/**
 * PassportController
 */
// 注册登录页面
Route::get('passport/index', 'PassportController@index');
// 提交登录表单
Route::post('passport/login', 'PassportController@login');
// 提交注册表单
Route::post('passport/register', 'PassportController@register');

/**
 * ProjectController
 */
// 项目首页
Route::get('project', 'ProjectController@index')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);
