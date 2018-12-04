<?php
/**
 * Created by PhpStorm.
 * User: kurisu
 * Date: 18-11-12
 * Time: 下午1:22
 */

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 20, //second

    // 关键信息
    'keys'    => [
        'default' => [
            'mixin_id'      => env('MIXIN_SDK_MIXIN_ID'),       //
            'client_id'     => env('MIXIN_SDK_CLIENT_ID'),      //
            'client_secret' => env('MIXIN_SDK_CLIENT_SECRET'),  //
            'pin'           => env('MIXIN_SDK_PIN'),            //
            'pin_token'     => env('MIXIN_SDK_PIN_TOKEN'),      //
            'session_id'    => env('MIXIN_SDK_SESSION_ID'),     //
            'private_key'   => '',                                    //import your private_key
        ],
    ],

    // 除非你知道你在做什么，否则不要改这个配置
    //'iterator' => microtime(true) * 100000
];