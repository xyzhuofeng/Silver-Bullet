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
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function invite(Request $request, $code)
    {
        if (empty($code)) {
            return view('member.invite', [
                'msg' => '加入失败：邀请码不能为空',
            ]);
        }
        // 解析邀请码
        $project_id = explode('_', $code)[0];
        $code_origin = Cache::get('invite_code_' . $project_id);
        $project = Project::where('project_id', $project_id)->first();
        if (!$project) {
            return view('member.invite', [
                'msg' => '加入失败：无法解析邀请码',
            ]);
        }
        if ($code == $code_origin) {
            // 加群处理
            $project_user = ProjectUser::where('user_id', session()->get('user_id'))
                ->where('project_id', $project_id)
                ->first();
            if ($project_user) {
                // 用户已加入项目，直接打开项目首页
                return view('member.invite', [
                    'msg' => '加入成功',
                ]);
            }
            $project_user = new ProjectUser();
            $project_user->setAttribute('project_id', $project_id);
            $project_user->setAttribute('user_id', session()->get('user_id'));

            $project_user->setAttribute('role', 'user');
            if ($project_user->save()) {
                // 用户成功加入项目，直接打开项目首页
                return view('member.invite', [
                    'msg' => '加入成功',
                ]);
            }
            return view('member.invite', [
                'msg' => '加入失败：无法写入记录',
            ]);
        }
        return view('member.invite', [
            'msg' => '加入失败：邀请码异常',
        ]);
    }

    /**
     * 创建邀请码
     *
     * 邀请码格式： {project_id}_[a-f0-9]{32}
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function genInviteCode(Request $request, $project_id)
    {
        if (!Cache::has('invite_code_' . $project_id)) {
            $code = $project_id . '_' . md5($project_id . time());
            Cache::put('invite_code_' . $project_id, $code, now()->addSeconds(900));  // 有效期十五分钟
        }
        $code = Cache::get('invite_code_' . $project_id);
        return response()->json([
            'info' => '获取成功',
            'status' => 1,
            'data' => [
                'url' => route('member/invite', [$code]),
                'image' => '',
            ]
        ]);
    }
}