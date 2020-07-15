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

    Route::middleware('throttle:'.config('throttle.rate_limit.register_or_login'))->group(function (){
        //发送短信
        Route::post('verificationCodes','VerificationCodesController@send')
             ->name('verificationCodes.send');
        //注册登录
        Route::post('registerOrLogin','UserController@registerOrLogin')
             ->name('api.login');
    });

    Route::middleware('throttle:'.config('throttle.rate_limit.access'))->group(function (){

    });

});


