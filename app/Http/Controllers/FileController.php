<?php

namespace App\Http\Controllers;

use App\Http\model\Account;
use App\Http\model\ProjectFile;
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
                $project_file->setAttribute('file_size', $file->getSize());
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

    /**
     * 预览目录
     * @param Request $request
     * @param string $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function previewDir(Request $request, string $project_id)
    {
        $virtual_path = $request->post('virtual_path');
        $project_file_list = ProjectFile::join(Account::table,
            Account::table . '.user_id',
            '=',
            ProjectFile::table . '.creator')
            ->select([
                ProjectFile::table . '.original_name',
                ProjectFile::table . '.updated_at',
                Account::table . '.user_name as creator_name',
                ProjectFile::table . '.file_size'
            ])
            ->where('project_id', $project_id)
            ->where('virtual_path', $virtual_path)
            ->get();
        foreach ($project_file_list as &$val) {
            $short_size = $val['file_size'];
            // 精简文件大小显示，按B、KB、MB、GB的方式显示
            if ($short_size >= 0 && $short_size < 1024) { // B
                $val['file_size'] = floor($short_size) . 'B';
            }
            if ($short_size >= 1024 && $short_size < 1048576) { // KB
                $val['file_size'] = floor($short_size / 1024) . 'KB';
            }
            if ($short_size >= 1048576 && $short_size < 1073741824) { // MB
                $val['file_size'] = floor($short_size / 1024 / 1024) . 'MB';
            }
            if ($short_size >= 1073741824) { // GB
                $val['file_size'] = floor($short_size / 1024 / 1024 / 1024) . 'GB';
            }
        }
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => $project_file_list
        ]);

    }
}
