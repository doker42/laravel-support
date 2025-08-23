<?php

namespace App\Messengers\Telegram;

use App\Helpers\TelegramConst;
use App\Jobs\TelegramSendMessage;
use Illuminate\Support\Facades\Log;

trait TelegramTrait
{

    public function getChatId($input)
    {
//        dd($input);


        if (isset($input['callback_query']['message']['chat']['id'])) {
            $chatId = $input['callback_query']['message']['chat']['id'];
        }
        elseif (isset($input['message']['from']['id'])) {
            $chatId = $input['message']['from']['id'];
        }
        elseif (isset($input['message']['chat']['id'])) {
            $chatId = $input['message']['chat']['id'];
        }
        elseif (isset($input['my_chat_member']['chat']['id'])) {
            $chatId = $input['my_chat_member']['chat']['id'];
        }
        else {

//            $error_service_message = [
//                'message'       => 'error Telegram bot',
//                'error_message' => 'Telegram bot chatId is empty'
//            ];
//            TelegramSendMessage::dispatch($error_service_message, TelegramConst::TYPE_ERROR);

            return null;
        }

        return $chatId;
    }



    public function getStartToken(array $input): string|null
    {
        if (isset($input['message']['entities'][0]['type'])) {

            if ($input['message']['entities'][0]['type'] == TelegramConst::WEBHOOK_HANDLER_TYPE_COMMAND) {

                if (isset($input['message']['text']) ) {

                    $text = $this->input['message']['text'];

                    if (str_contains($text, '/start')) {

                        $payload = explode(' ', $text);
                        return !empty($payload[1])
                            ? $payload[1]
                            : null;
                    }
                }
            }
        }

        return null;
    }
}