<?php

namespace App\Http\Controllers;

use App\Http\model\DirStructure;
use App\Http\model\Project;
use App\Http\model\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 项目控制器
 * @package App\Http\Controllers
 */
class ProjectController
{
    /**
     * 项目首页（看板）
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('project.index');
    }

    /**
     * 获取当前用户参与的项目列表（项目中心）
     *
     * 为AJAX获取数据设计的接口
     * @return \Illuminate\Http\JsonResponse
     */
    public function projList()
    {
        $project_model = new Project();
        $project_user_model = new ProjectUser();
        $data = DB::table($project_model->table)
            ->join($project_user_model->table,
                $project_model->table . '.project_id',
                '=',
                $project_user_model->table . '.project_id'
            )
            ->select($project_model->table . '.*')
            ->orderBy('updated_at', 'desc')
            ->where('user_id', session('user_id'))
            ->get();
        foreach ($data as &$val) {
            $val->project_thumb = asset('app/' . $val->project_thumb);
            $val->project_url = url('project', ['project_id' => $val->project_id]);
        }
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => $data
        ]);
    }

    /**
     * 创建项目信息
     *
     * 创建项目的同时，会将创建者添加到项目用户关联表中
     *
     * POST
     * project_name: 项目名称
     * project_comment: 项目备注
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $project_name = $request->post('project_name');
        $project_comment = $request->post('project_comment');
        $project = new Project();
        $project->setAttribute('project_name', $project_name);
        $project->setAttribute('project_comment', $project_comment);
        $project->setAttribute('project_thumb', 'proj_thumb/物品申请.png');
        $project->setAttribute('creator', $request->session()->get('user_id'));
        DB::beginTransaction();
        try {
            $project->save();
            // 添加创建者本人的项目用户关联记录
            $project_user = new ProjectUser();
            $project_user->setAttribute('project_id', $project->getAttribute('project_id'));
            $project_user->setAttribute('user_id', $request->session()->get('user_id'));
            $project_user->setAttribute('role', 'creator'); // 创建者角色
            $project_user->save();
            // 初始化文件系统根目录
            $dirStructure = new DirStructure();
            $dirStructure->setAttribute('project_id', $project->getAttribute('project_id'));
            $dirStructure->setAttribute('structure', json_encode([['path' => '全部文件', 'label' => '全部文件']]));
            $dirStructure->save();
            DB::commit();
            return response()->json([
                'info' => '创建成功',
                'status' => 1
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'info' => '创建失败',
                'status' => 0
            ]);
        }
    }

    /**
     * 获取指定项目信息
     *
     * GET
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function read(Request $request, $project_id)
    {
        $project_id = intval($project_id);
        // TODO 未完成
//        $project = Project::where('project_id',$project_id)->first();
//        var_dump($project);
        return view('project.read', [
            'project_id' => $project_id
        ]);
    }

    /**
     * 打开项目设置页面
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting(Request $request, $project_id)
    {
        $project = Project::where('project_id', $project_id)->first();
        return view('project.setting', [
            'project' => $project,
        ]);
    }

    /**
     * 上传封面图
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateThumb(Request $request, $project_id)
    {
        $project = Project::where('project_id', $project_id)->first();
        if (empty($project)) {
            return response()->json([
                'info' => '没有找到项目',
                'status' => 0,
            ]);
        }
        // 获取文件对象
        $file = $request->file('thumb');
        if (!$file) {
            return response()->json(['info' => '未选择文件', 'status' => 0]);
        }
        // 检查文件上传错误码
        if ($file->isValid()) {
            // 存储文件，返回相对路径，如：proj_thumb/Y8aWLJC5yitb3Ou41Jy9MK8E75OW3yJ1cingsD1K.txt
            $relative_path = $file->store('proj_thumb');
            // 成功移动文件的情况
            if ($relative_path) {
                // 写入文件信息
                $project->setAttribute('project_thumb', $relative_path);
                $project->save();
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
     * 编辑项目信息页面
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $project_id = $request->get('project_id');

    }

    /**
     * 更新项目信息
     *
     * PUT
     * @param Request $request
     */
    public function update(Request $request)
    {
        $project_id = $request->input('project_id');
    }

    /**
     * 删除项目
     *
     * DELETE
     * @param Request $request
     */
    public function delete(Request $request)
    {

    }
}
