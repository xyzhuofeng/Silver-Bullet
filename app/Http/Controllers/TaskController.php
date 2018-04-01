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
        return view('task.index', [
        ]);
    }

    /**
     * 获取项目所有任务
     * @param Request $request
     * @param string $project_id 项目id
     * @return \Illuminate\Http\JsonResponse
     */
    public function my(Request $request, $project_id)
    {
        $data = Task::join(Account::table,
            Account::table . '.user_id', '=', Task::table . '.creator'
        )
            ->where(Task::table . '.project_id', $project_id)
            ->orderBy(Task::table . '.created_at', 'desc')
            ->get();
        foreach ($data as &$val) {
            $member_list = TaskUser::join(Account::table,
                Account::table . '.user_id', '=', TaskUser::table . '.user_id'
            )
                ->where(TaskUser::table . '.task_id', $val->task_id)
                ->get();
            // 转换为bool方便渲染
            $val->task_user = $member_list;
            $val->is_finished = $val->is_finished == 1 ? true : false;
            $val->tag = json_decode($val->tag, true);
            $val->remark = nl2br($val->remark);
        }
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => $data
        ]);
    }

    /**
     * 获取未完成的任务
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unfinish(Request $request, $project_id)
    {
        $data = Task::join(Account::table,
            Account::table . '.user_id', '=', Task::table . '.creator'
        )
            ->where(Task::table . '.project_id', $project_id)
            ->where(Task::table . '.is_finished', 0)
            ->orderBy(Task::table . '.created_at', 'desc')
            ->get();
        foreach ($data as &$val) {
            $member_list = TaskUser::join(Account::table,
                Account::table . '.user_id', '=', TaskUser::table . '.user_id'
            )
                ->where(TaskUser::table . '.task_id', $val->task_id)
                ->get();
            // 转换为bool方便渲染
            $val->task_user = $member_list;
            $val->is_finished = $val->is_finished == 1 ? true : false;
            $val->tag = json_decode($val->tag, true);
            $val->remark = nl2br($val->remark);
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
        $tag_list = json_encode($request->post('tag_list'));
        $task_user = $request->post('task_user');
        if (empty($task_content)) {
            return response()->json(['info' => '任务内容不能为空', 'status' => 0]);
        }
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
            $task->setAttribute('tag', $tag_list);
            $task->save();
            foreach ($task_user as $value) {
                $task_user = new TaskUser();
                $task_user->setAttribute('task_id', $task->getAttribute('task_id'));
                $task_user->setAttribute('user_id', $value);
                $task_user->setAttribute('role', '参与者');
                $task_user->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'info' => '创建失败' . $exception->getMessage(),
                'status' => 0
            ]);
        }
        return response()->json([
            'info' => '创建成功',
            'status' => 1,
            'data' => $task
        ]);
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

    /**
     * 删除任务
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $project_id)
    {
        $task_id = $request->post('task_id');
        DB::beginTransaction();
        try {
            Task::where('project_id', $project_id)
                ->where('task_id', $task_id)
                ->delete();
            TaskUser::where('task_id', $task_id)
                ->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 0,
                'info' => '删除失败:' . $exception->getMessage(),
            ]);
        }
        return response()->json([
            'status' => 1,
            'info' => '删除成功',
        ]);
    }
}
