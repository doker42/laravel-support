<?php

return [

    'test' => env('TEST_TELEGRAM_LOGGER', 0),

    'channels' => [

        'info' => [
            'bot_token'     => env('TELEGRAM_TARGET_BOT_TOKEN', 'token'),
            'chat_group_id' => env('TELEGRAM_TARGET_LOG_INFO_CHAT_GROUP_ID')
        ],

        'error'  => [
            'bot_token'     => env('TELEGRAM_TARGET_BOT_TOKEN'),
            'chat_group_id' => env('TELEGRAM_TARGET_LOG_ERROR_CHAT_GROUP_ID')
        ],
    ],

];
