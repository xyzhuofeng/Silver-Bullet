<?php

namespace App\Http\Controllers;

use App\Http\model\Account;
use App\Http\model\Task;
use App\Http\model\TaskUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * 项目任务控制器
 * @package App\Http\Controllers
 */
class TaskController
{
    /**
     * 任务面板首页
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $project_id)
    {
        // 获取项目所有任务
        $task_list = Task::join(TaskUser::table,
            TaskUser::table . '.task_id', '=', Task::table . '.task_id'
        )
            ->where(Task::table . '.project_id', $project_id)
            ->orderBy('deadline', 'desc')
            ->orderBy(Task::table . '.updated_at', 'desc')
            ->get();
        // 转换为bool方便渲染
        foreach ($task_list as &$val) {
            $val->is_finished = $val->is_finished == 1 ? true : false;
        }
        return view('task.index', [
            'task_list' => $task_list
        ]);
    }

    /**
     * 获取我的项目任务
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Http\JsonResponse
     */
    public function my(Request $request, $project_id)
    {
        $data = Task::join(TaskUser::table,
            TaskUser::table . '.task_id', '=', Task::table . '.task_id'
        )
            ->join(Account::table,
                Account::table . '.user_id', '=', Task::table . '.creator'
            )
            ->where(TaskUser::table . '.user_id', session()->get('user_id'))
            ->where(Task::table . '.project_id', $project_id)
            ->orderBy(Task::table . '.created_at', 'desc')
            ->orderBy(Task::table . '.updated_at', 'desc')
            ->get();
        foreach ($data as &$val) {
            // 转换为bool方便渲染
            $val->is_finished = $val->is_finished == 1 ? true : false;
            $val->tag = json_decode($val->tag, true);
        }
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => $data
        ]);
    }

    /**
     * 创建任务
     *
     * POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $task_content = $request->post('task_content');
        $remark = $request->post('remark');
        $deadline = $request->post('deadline');
        $project_id = $request->post('project_id');
        DB::beginTransaction();
        try {
            // 分别写入任务和用户任务关联表
            $task = new Task();
            $task->setAttribute('task_content', $task_content);
            $task->setAttribute('remark', $remark);
            $task->setAttribute('creator', session()->get('user_id'));
            $task->setAttribute('project_id', $project_id);
            $task->setAttribute('is_finished', 0);
            $task->setAttribute('deadline', $deadline);
            $task->save();
            $task_user = new TaskUser();
            $task_user->setAttribute('task_id', $task->getAttribute('task_id'));
            $task_user->setAttribute('user_id', session()->get('user_id'));
            $task_user->setAttribute('role', '创建者');
            $task_user->save();
            return response()->json([
                'info' => '创建成功',
                'status' => 1,
                'data' => $task
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'info' => '创建失败' . $exception->getMessage(),
                'status' => 0
            ]);
        }
    }

    /**
     * 完成任务
     * 可切换完成和未完成
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(Request $request, $project_id)
    {
        $task_id = $request->post('task_id');
        $task = Task::where('project_id', $project_id)
            ->where('task_id', $task_id)
            ->first();
        if ($task->getAttribute('is_finished') === 0) {
            $task->setAttribute('is_finished', 1);
        } else {
            $task->setAttribute('is_finished', 0);
        }
        if ($task->save()) {
            return response()->json([
                'status' => 1,
                'info' => '操作成功',
                'data' => [
                    'is_finished' => $task->getAttribute('is_finished')
                ],
            ]);
        }
        return response()->json([
            'status' => 0,
            'info' => '操作失败',
        ]);
    }
}
