<?php

namespace App\Messengers\Telegram\Buttons;

class InlineButton
{
    private static int $button_number = 1;
    public static array $buttons = [
        'inline_keyboard' => []
    ];


    public static function add(mixed $text, string $action, array $data, int $row = 1)
    {
        $data['action'] = $action;
//        $data['number'] = self::$button_number;
//        self::$button_number++;
        self::$buttons['inline_keyboard'][$row - 1 ][] = [
            'text' => $text,
            'callback_data' => json_encode($data),
//            'remove_keyboard'  => true
        ];
    }

    public static function link(mixed $text, string $url, int $row = 1)
    {
        self::$buttons['inline_keyboard'][$row - 1][] = [
            'text' => $text,
            'url'  => $url
        ];
    }
}
