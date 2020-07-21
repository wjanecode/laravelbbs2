<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use App\Notifications\UserRegisteredBySms;
use iBrand\Sms\Sms;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class AuthorizationsController extends ApiController
{
    protected $sms;
    public function __construct(Sms $sms) {
        $this->sms = $sms;
    }

    //api账密登录 邮箱或者用户名
    public function store(AuthorizationRequest $request)
    {

        $account = $request->account;
        $credential['password'] = $request->password;

        if(filter_var($account,FILTER_VALIDATE_EMAIL)){
             $credential['email'] = $account;
        }else{
             $credential['name'] = $account;
        }


        //这里实现的是 jwt attempt方法,该方法认证成功会返回 token 值,失败返回false
        if( ! $token = auth('api')->attempt($credential) ) {
            return $this->errorResponse(403,'用户名或密码错误',1003);
        }

        return $this->responseWithToken($token);
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
            return response()->json(['message' => '非法登录']);
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

    /**
     * 微信登录
     * @param SocialAuthorizationRequest $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
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
            return response()->json($user,200);
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

        //获取用户 token,用户 jwt 登录会返回 token
        $token = auth('api')->login($user);

        //返回 token
        return $this->responseWithToken($token);

    }

    /**
     * 手机号验证码注册登录
     * @param SocialAuthorizationRequest $request
     * @param Sms $sms
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function phoneStore(SocialAuthorizationRequest $request)
    {

        $phone = $request->phone;
        $code = $request->code;

        //验证code是否正确

        if ($this->sms->checkCode($phone,$code)){

            //验证通过
            //判断用户是否存在
            //用户存在,返回token
            //用户不存在,新建用户,然后登录
            $user = User::where('phone',$phone)->get()->first();

            if ( ! $user)
            {
                //用户不存在,新建用户,然后登录
                $data = [
                    'name' => 'bbs'.Str::random(10),
                    'email'=> \Str::random(8).'@'.\Str::random(3).'.'.\Str::random(3),
                    'phone'=> $phone,
                    'password' => Hash::make(Str::random(8)),
                    'email_verified_at' => now()->toDateTimeString(),
                ];
                $user = User::create($data);

                //通知用户修改信息
                $user->notify( new UserRegisteredBySms($user));
            }

            $token = auth('api')->login($user);

            //返回 token
            return $this->responseWithToken($token);

        }else{
            return $this->errorResponse(403,'验证码不正确或已过期',1004);
        }
    }

    /**
     * 返回token数据
     * @param $token
     *
     * @return array
     */
    public function responseWithToken( $token ) {
        return response()->json([
            //token
            'access_token' => $token,
            //token 类型
            'token_type'   => 'Bearer',
            //过期时间,有个默认的时间
            'expired_at'   => auth('api')->factory()->getTTL() * 60
        ],201);
    }

    public function update(Request $request) {

        $token = auth('api')->refresh();
        return $this->responseWithToken($token);
    }

    public function destroy() {
        auth('api')->logout();
        return response()->json(null,204);
    }

}
