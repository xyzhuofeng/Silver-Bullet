<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * 用户个人中心
     */
    public function index()
    {
        return view('user/index');
    }
}
