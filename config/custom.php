<?php

return [

    'telegram' =>  [
        'enable'    => false,
        'bot_token' => env('TELEGRAM_BOT_TOKEN', 'your_bot_token_here'),
        'chat_id'   => env('TELEGRAM_CHAT_ID', 'your_chat_id_here'),
    ],

    'targets' => [
        'limit'  =>  env('TARGETS_LIMIT', 500),
    ]



];

