<?php

namespace App\Http\Controllers;

/**
 * 首页控制器
 * @package App\Http\Controllers\Controller
 */
class IndexController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        return view('index.index', ['msg' => 'hello']);
    }
}
