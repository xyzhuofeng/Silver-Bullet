<?php
/**
 * Created by PhpStorm.
 * User: Li
 * Date: 2017/11/30
 * Time: 10:01
 */

namespace App\Http\Controllers;

/**
 * 用户通行证管理器
 * @package App\Http\Controllers
 */
class PassportController extends Controller
{
    /**
     * 登录注册页面
     */
    public function index()
    {
        return view('passport.index');
    }
}
