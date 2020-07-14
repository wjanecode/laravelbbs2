<?php

/*
 * This file is part of ibrand/laravel-sms.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
	'route' => [
		'prefix'     => 'sms',
		'middleware' => ['api'],
	],

	'easy_sms' => [
		'timeout'  => 5.0,

		// 默认发送配置
		'default'  => [
			// 网关调用策略，默认：顺序调用
			'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

			// 默认可用的发送网关
			'gateways' => [
				'errorlog',
			],
		],

		// 可用的网关配置
		'gateways' => [
            'aliyun' => [
                'access_key_id'     => env('SMS_ALIYUN_ACCESS_KEY_ID'),
                'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET'),
                'sign_name'         => env('SMS_ALIYUN_SIGN_NAME'),
                'code_template_id'  => env('SMS_ALIYUN_TEMPLATE_ID'),
            ],
			'errorlog' => [
				'file' => storage_path('logs/laravel-sms.log'),
			],

			'yunpian' => [
				'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
			],



			'alidayu' => [
				//...
			],
		],
	],

	'code' => [
		'length'       => 6,
		'validMinutes' => 5,
		'maxAttempts'  => 0,
	],

	'data' => [
		'product' => '',
	],

	'dblog' => true,

	'content' => '【your app signature】亲爱的用户，您的验证码是%s。有效期为%s分钟，请尽快验证。',

	'storage' => \iBrand\Sms\Storage\CacheStorage::class,

	'enable_rate_limit' => env('SMS_ENABLE_RATE_LIMIT', true),//是否开启

	'rate_limit_middleware' => 'iBrand\Sms\Http\Middleware\ThrottleRequests',

	'rate_limit_count' => env('SMS_RATE_LIMIT_COUNT', 10), //次数

	'rate_limit_time' => env('SMS_RATE_LIMIT_TIME', 60), //分钟
];
