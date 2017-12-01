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
     */
    public function login(Request $request){
        $email = $request->post('email');
        $password = $request->post('password');

    }

    /**
     * 注册逻辑
     *
     * POST
     * email: 用户邮箱
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $email = $request->post('email');
        $password = $request->post('password');
        $account = new Account();
        $account->setAttribute('email',$email);
        $account->setAttribute('user_name',$email);
        $account->setAttribute('user_password',Password::crypt($password));
        $account->setAttribute('created_at',time());
        $account->setAttribute('updated_at',time());
        $account->save();
        return response()->json([
            'info' => '注册成功',
            'code' => '1'
        ]);
    }
}
