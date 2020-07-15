<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class CaptchaController extends Controller
{
    //
    public function store( CaptchaRequest $request )
    {
        $phone = $request->get('phone');
        $key = 'captcha-' . Str::random(10);

        //生成验证码
        // Will build phrases of 4 characters, only digits
        $phraseBuilder = new PhraseBuilder(4, '0123456789');
        $captcha_builder = new CaptchaBuilder(null,$phraseBuilder);
        $captcha = $captcha_builder->build();

        //过期时间,5分钟后
        $expired_at = now()->addMinutes(5);
        //缓存key 手机号 验证码
        Cache::put($key,['phone' => $phone, 'code' => $captcha->getPhrase()],$expired_at);

        //-------调试
        var_dump(Cache::get($key));

        //返回验证码和key,过期时间
        $result = [
            'captcha_key' => $key,
            'captcha_img_content' => $captcha->inline(),//验证码图片 base64
            'expired_at' => $expired_at,
        ];

        return response()->json($result,201);
    }
}
