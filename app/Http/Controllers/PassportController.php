<?php
/**
 * Created by PhpStorm.
 * User: Li
 * Date: 2017/11/30
 * Time: 10:01
 */

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
        $request->session()->put('email', $account->email);
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
        $account->setAttribute('created_at', time());
        $account->setAttribute('updated_at', time());
        if ($account->save()) {
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
}
