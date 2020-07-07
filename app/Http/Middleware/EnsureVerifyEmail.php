<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * 强制用户验证邮箱,未验证的跳转到验证页面
 * Class EnsureVerifyEmail
 * @package App\Http\Middleware
 */
class EnsureVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //三个验证条件成立,则跳到提示验证页面
        //已登录,
        //未验证邮箱
        //路由不是验证邮箱的链接,不是logout
        if( Auth::check() &&
           ! Auth::user()->hasVerifiedEmail() &&
           ! $request->is('email/*','logout')){

            //根据客户端要求返回数据,要求json就返回错误信息
            return $request->expectsJson()
                ? abort(403,'你的邮箱还没验证,请登录邮箱点击链接验证')
                : redirect()->route('verification.notice');


        }

        return $next($request);
    }
}
