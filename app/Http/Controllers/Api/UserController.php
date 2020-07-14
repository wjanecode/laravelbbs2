<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use iBrand\Sms\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    //
    public function registerOrLogin(UserRequest $request, Sms $sms)
    {
        $phone = $request->get('phone');
        $code = $request->get('code');
        //验证code是否正确
        if ($sms->checkCode($phone,$code)){

            //验证通过
            //判断用户是否存在
            //用户存在,返回用户信息和token
            $users = User::where('phone',$phone)->get();

            if ($user = $users->first())
            {
                $result['token'] = $user->createToken('login')->accessToken;
                $result['name'] = $user->name;
                return response()->json(['result'=>$result],200);

            }else{
                //用户不存在,新建用户,然后登录

                $data = [
                    'name' => 'bbs'.Str::random(10),
                    'email'=> Str::random(8).'@'.Str::random(3).'.'.Str::random(3),
                    'phone'=> $phone,
                    'password' => Hash::make(Str::random(8))

                ];
                $user = User::create($data);
                $result['token'] = $user->createToken('login')->accessToken;
                $result['name'] = $user->name;
                return response()->json(['result'=>$result],200);
            }

        }else{
            return response()->json(['message' => '验证码错误或已过期'])->setStatusCode(401);
        }

    }
}
