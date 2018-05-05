<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 用户登录状态检查中间件
 * @package App\Http\Middleware
 */
class CheckLoginStatus
{
    public function handle($request, Closure $next)
    {
        // 检查登录状态
        if (!$request->session()->has('user_id')) {
            return redirect('passport/index?redirect_url='.urlencode(url()->current()));
        }
        return $next($request);
    }
}
