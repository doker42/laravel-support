<?php

namespace App\Socialite\Telegram\Buttons;

class KeyboardButton
{
    private static int $button_number = 1;

    public static array $buttons = [
        'keyboard' => [],
        'resize_keyboard' => true
    ];

//    public static function add(mixed $text, int $row = 1)
//    {
//        self::$button_number++;
//        self::$buttons['keyboard'][$row -1 ] = [
//            'text' => $text,
//        ];
//    }


    public static function add(mixed $text)
    {
        self::$button_number++;
        self::$buttons['keyboard'][] = [['text' => $text]];
    }

    public static function remove()
    {
        self::$buttons = [
            'remove_keyboard' => true,
        ];
    }
}