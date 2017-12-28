<?php

namespace App\Http\Controllers;

use App\Http\model\Account;
use hyperqing\Password;
use Illuminate\Http\Request;

/**
 * 用户通行证管理器
 * @package App\Http\Controllers
 */
class PassportController extends Controller
{
    /**
     * 登录注册页面
     */
    public function index()
    {
        return view('passport.index');
    }

    /**
     * 登录逻辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        if (empty($email) || empty($password)) {
            return response()->json([
                'info' => '邮箱和密码不能为空',
                'code' => 0
            ]);
        }
        $account = Account::where('email', $email)->first();
        if (!$account) {
            return response()->json([
                'info' => '邮箱不存在',
                'code' => 0
            ]);
        }
        if (!Password::verify($password, $account->user_password)) {
            return response()->json([
                'info' => '邮箱或密码错误',
                'code' => 0
            ]);
        }
        $request->session()->put('user_id', $account->user_id);
        $request->session()->put('user_name', $account->user_name);
        $request->session()->put('user_avatar', asset($account->user_avatar));
        $request->session()->put('email', $account->email);
        $request->session()->put('job', $account->job);
        return response()->json([
            'info' => '登录成功',
            'status' => 1,
            'redirect_url' => url('project')
        ]);
    }

    /**
     * 注册逻辑
     *
     * POST
     * email: 用户邮箱
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $name = $request->post('name');
        $account = new Account();
        $account->setAttribute('email', $email);
        $account->setAttribute('user_name', $name);
        $account->setAttribute('user_password', Password::crypt($password));
        $account->setAttribute('user_avatar', 'app/avatar/男.png');
        $account->setCreatedAt(time());
        $account->setUpdatedAt(time());
        if ($account->save()) {
            $request->session()->put('user_id', $account->getAttribute('user_id'));
            $request->session()->put('user_name', $account->getAttribute('user_name'));
            $request->session()->put('user_avatar', asset($account->getAttribute('user_avatar')));
            $request->session()->put('email', $account->getAttribute('email'));
            $request->session()->put('job', '');
            return response()->json([
                'info' => '注册成功！正在跳转到项目中心...',
                'status' => 1,
                'redirect_url' => url('project')
            ]);
        }
        return response()->json([
            'info' => '注册失败',
            'status' => 0
        ]);
    }

    /**
     * 退出登录
     *
     * 退出登录后返回登录页面
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('passport/index');
    }

    /**
     * 修改密码
     *
     * POST
     * original_password: 原密码
     * new_password: 新密码
     * confirm_password: 确认密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updatePassword(Request $request)
    {
        $original_password = $request->post('original_password');
        $new_password = $request->post('new_password');
        $confirm_password = $request->post('confirm_password');
        // 检查原密码
        $account = Account::where('user_id', session('user_id'))->first();
        if (!Password::verify($original_password, $account->user_password)) {
            return response()->json(['info' => '原密码错误', 'status' => 0]);
        }
        if (empty($new_password) || empty($confirm_password)) {
            return response()->json(['info' => '新密码不能为空', 'status' => 0]);
        }
        if ($new_password !== $confirm_password) {
            return response()->json(['info' => '两次输入密码不一致', 'status' => 0]);
        }
        $account->user_password = Password::crypt($confirm_password);
        if ($account->save()) {
            return response()->json(['info' => '更改成功', 'status' => 1]);
        }
        return response()->json(['info' => '更改失败', 'status' => 0]);
    }

    /**
     * 更改职位
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateJob(Request $request)
    {
        $job = $request->post('job');
        $account = Account::where('user_id', session('user_id'))->first();
        $account->job = $job;
        if ($account->save()) {
            $request->session()->put('job', $job);
            return response()->json(['info' => '更改成功', 'status' => 1]);
        }
        return response()->json(['info' => '更改失败', 'status' => 0]);
    }

    /**
     * 更改用户名
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateName(Request $request)
    {
        $user_name = $request->post('user_name');
        if (empty($user_name)) {
            return response()->json(['info' => '姓名不能为空', 'status' => 0]);
        }
        $account = Account::where('user_id', session('user_id'))->first();
        $account->user_name = $user_name;
        if ($account->save()) {
            $request->session()->put('user_name', $user_name);
            return response()->json(['info' => '更改成功', 'status' => 1]);
        }
        return response()->json(['info' => '更改失败', 'status' => 0]);
    }

    /**
     * 更新头像
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(Request $request)
    {
        // 获取文件对象
        $file = $request->file('avatar');
        if (!$file) {
            return response()->json(['info' => '未选择文件', 'status' => 0]);
        }
        // 检查文件上传错误码
        if ($file->isValid()) {
            // 存储文件，返回相对路径，如：avatar/Y8aWLJC5yitb3Ou41Jy9MK8E75OW3yJ1cingsD1K.txt
            $relative_path = $file->store('avatar');
            // 成功移动文件的情况
            if ($relative_path) {
                // 写入文件信息
                $account = Account::where('user_id', session('user_id'))->first();
                $account->user_avatar = 'app/' . $relative_path;
                if ($account->save()) {
                    $request->session()->put('user_avatar', asset('app/' . $relative_path));
                    return response()->json([
                        'info' => '上传成功',
                        'status' => 1,
                        'data' => [
                            'fileUrl' => asset('app/' . $relative_path)
                        ]
                    ]);
                }
                return response()->json([
                    'info' => '写入失败',
                    'status' => 0
                ]);
            }
        }
        return response()->json([
            'info' => '上传失败，错误码：' . $file->getErrorMessage(),
            'status' => 0
        ]);
    }
}
