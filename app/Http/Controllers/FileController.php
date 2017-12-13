<?php

namespace App\Http\Controllers;

use App\Http\model\ProjectFile;
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
        // 获取文件放置的虚拟目录信息
        $virtual_path = $request->post('virtual_path');
        // 获取文件对象
        $file = $request->file('myfile');
        if (!$file) {
            return response()->json(['info' => '未选择文件', 'status' => 0]);
        }
        // 检查文件上传错误码
        if ($file->isValid()) {
            // 存储文件，返回相对路径，如：myfile/Y8aWLJC5yitb3Ou41Jy9MK8E75OW3yJ1cingsD1K.txt
            $relative_path = $file->store('myfile');
            // 成功移动文件的情况
            if ($relative_path) {
                // 写入文件信息
                $project_file = new ProjectFile();
                $project_file->setAttribute('creator', session('user_id'));
                $project_file->setAttribute('project_id', $project_id);
                $project_file->setAttribute('virtual_path', $virtual_path);
                $project_file->setAttribute('relative_path', $relative_path);
                $project_file->setAttribute('original_name', $file->getClientOriginalName());
                $project_file->setAttribute('hash_name', $file->hashName());
                $project_file->save();
                return response()->json([
                    'info' => '上传成功',
                    'status' => 1,
                    'data' => [
                        'fileUrl' => asset('app/' . $relative_path)
                    ]
                ]);
            }
        }
        return response()->json([
            'info' => '上传失败，错误码：' . $file->getErrorMessage(),
            'status' => 0
        ]);

    }
}
