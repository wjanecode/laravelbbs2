<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TestController extends Controller
{
    //
    public function index(  ) {

        //--------通过 access_token 获取用户信息 app_id app_secret 保存在客户端
//        $accessToken = '35_VADHVXS2qH1UR5GfVsgah4GwjgLPEruUZcZyXnp7vy5r-7p__RYpr34ZsGgczxpnc_Q0ejNkM45JloZCrAivuA';//客户端提交的
//        $openID = 'xxx';//客户端提交
//        $driver = Socialite::driver('weixin');
//        $driver->setOpenId($openID);
//        $oauthUser = $driver->userFromToken($accessToken);
//        dd($oauthUser);

//        //--------通过 code 获取 access_token app_secret 保存在服务端
//        $code = '081Nyjkt0xw7si1d36nt0HWikt0Nyjkw';//客户端提交的,code只能用一次
//        $driver = Socialite::driver('weixin');
//        $response = $driver->getAccessTokenResponse($code);
//        $driver->setOpenId($response['openid']);
//        $oauthUser = $driver->userFromToken($response['access_token']);
//        dd($oauthUser);

        $array = ['a'=>'1','b'=>'222'];
        $a = key_exists('c',$array) ? $array['c']: null;
        $user = User::where('id','1')->get()->first();
        dd($user);



    }
}
