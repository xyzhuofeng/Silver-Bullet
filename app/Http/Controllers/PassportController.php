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
        $request->session()->put('user_avatar', $account->user_avatar);
        $request->session()->put('email', $account->email);
        return response()->json([
            'info' => '登录成功',
            'status' => 1,
            'redirect_url' => url('project/index')
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
        $account->setAttribute('user_avatar', 'images/男.png');
        $account->setCreatedAt(time());
        $account->setUpdatedAt(time());
        if ($account->save()) {
            $request->session()->put('user_id', $account->getAttribute('user_id'));
            $request->session()->put('user_name', $account->getAttribute('user_name'));
            $request->session()->put('user_avatar', $account->getAttribute('user_avatar'));
            $request->session()->put('email', $account->getAttribute('email'));
            return response()->json([
                'info' => '注册成功！正在跳转到项目中心...',
                'status' => 1,
                'redirect_url' => url('project/index')
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
}
