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
        //生成 4 位随机码；
        //用 Sms 发送短信到用户手机；
        //发送成功后，生成一个 key，在缓存中存储这个 key 对应的手机以及验证码，5 分钟过期；
        //将 key 返回给客户端。
        //这里使用了集成的,直接在 配置文件配置就行
        try
        {
            $result = $sms->send($request->get('phone'));
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
        return \response()->json(['message'=>'服务出错,短信发送失败,稍后再试'])->setStatusCode(500);
    }

    public function verify(Request $request) {

    }


}
