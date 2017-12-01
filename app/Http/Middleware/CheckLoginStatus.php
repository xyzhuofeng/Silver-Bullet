<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 检查登录状态
        if (!$request->session()->has('user_id')) {
            return redirect('passport/index');
        }
        return $next($request);
    }
}
