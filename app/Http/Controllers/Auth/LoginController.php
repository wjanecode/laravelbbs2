<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * 重写登录方法,添加用户名和邮箱登录
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        //使用集合遍历,contains()只要一项返回true,结果就会返回true
        //验证的是表单的account字段
        return collect(['name','email'])->contains(function ($value) use ($request) {
            $account = $request->get($this->username());
            $password = $request->get('password');

            return $this->guard()->attempt(
                //尝试登录,参数是数据
                [$value => $account,'password' => $password ], $request->filled('remember')
            );
        });
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin( \Illuminate\Http\Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha'
        ],[
            'captcha.required' => ':attribute 不能为空',
            'captcha.captcha' => '验证码错误'
        ],[
            $this->username() => '账号',
        ]
        );
    }

    /**
     * 重写方法,指定前端的用户登录使用的表单字段
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }
}
