<?php

namespace App\Http\Controllers;

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
            ->where(TaskUser::table . '.user_id', session()->get('user_id'))
            ->where(Task::table . '.project_id', $project_id)
            ->orderBy('deadline','desc')
            ->orderBy(Task::table . '.updated_at','desc')
            ->get();
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
        $deadline = $request->post('deadline');
        $project_id = $request->post('project_id');
        $task = new Task();
        $task->setAttribute('task_content', $task_content);
        $task->setAttribute('creator', session()->get('user_id'));
        $task->setAttribute('project_id', $project_id);
        $task->setAttribute('is_finished', 0);
        $task->setAttribute('deadline', $deadline);
        DB::beginTransaction();
        try {
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
}
