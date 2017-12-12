<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        return view('file.index2', [
            'project_id' => $project_id
        ]);
    }

    /**
     * 文件管理器
     */
    public function explorer()
    {

    }

    /**
     * 文件上传
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $project_id)
    {
        var_dump($request->file());
        var_dump($request->post());

        return;
        if ($request->file('myfile')->isValid()) {
            $path = $request->file('myfile')->store('myfile');
            if ($path) {
                return response()->json([
                    'info' => '上传成功',
                    'status' => 1,
                    'data' => [
                        'fileUrl' => asset('app/' . $path)
                    ]
                ]);
            }
        }
        return response()->json([
            'info' => '上传失败',
            'status' => 0
        ]);

    }

}
