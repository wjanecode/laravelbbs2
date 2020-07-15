<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VerificationCodeRequest;
use http\Env\Response;
use iBrand\Sms\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Overtrue\EasySms\Exceptions\Exception;

class VerificationCodesController extends ApiController
{
    /**
     * 发送短信验证码
     * @param VerificationCodeRequest $request
     * @param Sms $sms
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(VerificationCodeRequest $request,Sms $sms )
    {
        //思路:
        //判断图片验证码和过期时间
        //从缓存取出手机
        //用 Sms 发送短信到用户手机；
        //发送成功后，生成一个 key，在缓存中存储这个 key 对应的手机以及验证码，5 分钟过期；
        //将 key 返回给客户端。
        //这里使用了集成的,直接在 配置文件配置就行

        $captchaData = Cache::get($request->get('captcha_key'));

        //dd($captchaData);

        if (! $captchaData){
            //图片验证码已过期,直接返回
            abort(401,'图片验证码已过期,请刷新');
        }

        if (! hash_equals($captchaData['code'],$request->get('captcha'))){
            //验证码不正确
            abort(401,'图片验证码错误');
        }

        try
        {
            $result = $sms->send($captchaData['phone']);
        }
        catch(Exception $exception)
        {
            $message = $exception->getMessage();
            //抛出异常,Throw an HttpException with the given data.
            abort(500,$message ? : '短信发送异常');
        }

        //判断发送结果
        //发送成功,生成随机key,并缓存对应手机号和验证码
        if ($result)
        {
            //返回key
            //通过key可以去调用验证接口,判断验证码是否正确
            return response()->json([
                'key' => $sms->getKey(),
                'message' => '验证码已经发送至该手机号,请检查手机'
            ])->setStatusCode(200);
        }

        //发送失败
        return \response()->json(['message'=>'请求次数过多,稍后再试'])->setStatusCode(500);
    }

    public function verify(Request $request) {

    }


}
