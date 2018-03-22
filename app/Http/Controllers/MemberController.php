<?php

namespace App\Http\Controllers;

use App\Http\model\Account;
use App\Http\model\Project;
use App\Http\model\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * 项目控制器
 * @package App\Http\Controllers
 */
class MemberController
{
    public function index(Request $request, $project_id)
    {
        $project = Project::where('project_id', $project_id)->first();
        if (empty($project)) {
            return response()->json([
                'info' => '没有找到项目',
                'status' => 0,
            ]);
        }
        // 获取指定项目指定目录的文件列表
        $project_user_list = ProjectUser::join(Account::table,
            Account::tableWithDot . 'user_id',
            '=',
            ProjectUser::tableWithDot . 'user_id')
            ->select([
                Account::tableWithDot . 'user_id',
                Account::tableWithDot . 'user_name',
                Account::tableWithDot . 'user_avatar',
                Account::tableWithDot . 'job',
                ProjectUser::tableWithDot . 'role',
            ])
            ->where('project_id', $project_id)
            ->orderBy('role', 'asc')
            ->get();
        foreach ($project_user_list as &$val) {
            $val['user_avatar'] = asset($val['user_avatar']);
        }
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => [
                'project_user_list' => $project_user_list
            ]
        ]);
    }

    /**
     * 邀请链接
     */
    public function invite(Request $request, $code)
    {

    }

    /**
     * 创建邀请码
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function genInviteCode(Request $request, $project_id)
    {
        if (!Cache::has('invite_code_' . $project_id)) {
            $code = md5($project_id . time());
            Cache::put('invite_code_' . $project_id, $code, now()->addSeconds(300));  // 有效期五分钟
        }
        $code = Cache::get('invite_code_' . $project_id);
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => [
                'url' => route('member/invite', [$project_id, $code]),
                'image' => '',
            ]
        ]);
    }
}