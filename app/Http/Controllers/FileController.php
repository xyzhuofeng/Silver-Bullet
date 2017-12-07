<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


/**
 * 文件模块控制器
 * @package App\Http\Controllers
 */
class FileController extends Controller
{
    /**
     * 首页
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $project_id)
    {
        return view('file.index', [
            'project_id' => $project_id
        ]);
    }
}
