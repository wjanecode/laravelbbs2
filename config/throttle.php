<?php

return [
    //根据ip来限制的,用大量代理ip可以攻击
    'rate_limit' => [
        //访问频率
        'access' => '60,1',
        //登录注册频率
        'register_or_login' => '60,1',
    ],

];
