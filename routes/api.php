<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function (){

    //登录相关
    Route::middleware('throttle:'.config('throttle.rate_limit.register_or_login'))->group(function (){

        //图片验证码,需要手机号
        Route::post('captcha', 'CaptchaController@store')
             ->name('api.captcha.store');

        //发送短信验证码,需要先获取图片验证码
        Route::post('verificationCodes','VerificationCodesController@send')
             ->name('api.verificationCodes.send');


        //账密登录
        Route::post('authorizations','AuthorizationsController@store')
             ->name('api.authorizations.store');

        //第三方登录
        Route::post('socials/{socials_type}/authorizations','AuthorizationsController@socialsStore')
            ->name('api.socials.authorizations.store');

        //手机注册登录,需要手机号和短信验证码
        Route::post('phone/authorizations','AuthorizationsController@socialsStore')
             ->name('api.phone.authorizations.store');

        //刷新 token
        Route::put('authorizations/current','AuthorizationsController@update')
            ->name('api.authorizations.update');

        //删除 token
        Route::delete('authorizations/current','AuthorizationsController@delete')
            ->name('api.authorizations.destroy');
    });

    //用户信息
    Route::middleware('throttle:' . config('throttle.rate_limit.access'))->group(function () {

        // 游客可以访问的接口
         // 某个用户的详情
         Route::get('users/{user}', 'UsersController@show')
              ->name('api.users.show');

         // 登录后可以访问的接口
         Route::middleware('auth:api')->group(function() {
             // 当前登录用户信息
             Route::get('user', 'UsersController@me')
                  ->name('api.user.show');
             // 编辑登录用户信息
             Route::patch('user', 'UsersController@update')
                  ->name('user.update');
             //上传个人图片
             Route::post('images','ImagesController@store')
                 ->name('api.images.store');

         });
     });

    Route::middleware('throttle:'.config('throttle.rate_limit.access'))->group(function (){

    });

});


