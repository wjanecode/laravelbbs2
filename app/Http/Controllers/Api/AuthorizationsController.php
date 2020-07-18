<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class AuthorizationsController extends Controller
{
    //api账密登录
    public function store(  ) {

    }
    /**
     * 第三方登录
     * @param $socials_type
     * @param SocialAuthorizationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function socialsStore($socials_type,SocialAuthorizationRequest $request)
    {
        //dd($socials_type);
        //限制第三方登录
        if (!in_array($socials_type, ['weixin','phone'])) {
            return $this->response->errorBadRequest();
        }
        //根据请求调用不同方法
        switch ($socials_type)
        {
            case 'weixin':
                return $this->weixinStore($request);
            case 'phone' :
                return $this->phoneStore($request);
            default :
                abort('400','第三方登录路由参数错误');
        }
    }

    public function weixinStore(SocialAuthorizationRequest $request)
    {

        try
        {
           //使用授权码换取用户信息
           $code = $request->code;
           $driver = Socialite::driver('weixin');
           $response = $driver->getAccessTokenResponse($code);

        }catch (\Exception $exception){
           abort(400,$exception->getMessage());
        }

        $open_id = $response['openid'];
        $access_token = $response['access_token'];
        $driver->setOpenId($open_id);
        $oauthUser = $driver->userFromToken($access_token);
        //只有在用户将公众号绑定到微信开放平台帐号后，才会出现 unionid 字段。这里 有相关说明。但是由于微信开放平台只有通过认证才能绑定公众号，代码做了兼容处理。
        $union_id = key_exists('unionid',$oauthUser) ? $oauthUser['unionid']: null;

        //根据 openid 判断用户是否已注册
        $user = User::where('weixin_openid','='.'')->get()->first();

        if($user) {
            //用户存在,登录
            return response()->json($user,201);
        }else{

            //注册
            $data = [
                'name' => $oauthUser->getNickname(),
                'avatar' => $oauthUser->getAvatar(),
                'weixin_openid' => $oauthUser->getId(),
                'weixin_unionid' => $union_id,
            ];

            $user = User::create($data);
        }

        return response()->json($user,201);

    }

    public function phoneStore(  ) {

    }

}
