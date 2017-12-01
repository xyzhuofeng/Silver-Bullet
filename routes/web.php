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

// 首页
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');
// 注册登录页面
Route::get('/login', 'PassportController@index');
// 项目首页
Route::get('/project', 'ProjectController@index')
    ->middleware(\App\Http\Middleware\CheckLoginStatus::class);