<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TelegramConst;
use App\Http\Controllers\Controller;

use App\Messengers\Telegram\TelegramTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    use TelegramTrait;

    private object $bot;
    private array $input;
    private int|null $chatId;

    public function __construct(Request $request)
    {
        $this->bot = Telegram::bot(env('LASER_BOT'));
        $this->input = $request->except('_token');
        $this->chatId = $this->getChatId($this->input);
    }

    public function laserHook(Request $request): void
    {
//        dd($this->chatId);

        Log::info('Chat_ID : ' . $this->chatId);

        if ($this->chatId) {

//            $startToken = $this->getStartToken($this->input);
            $this->hookHandler($request, $this->input, $this->chatId);

            Log::info($this->input);

        }
    }

    private function hookHandler(Request $request, $input, $chatId)
    {
        Log::info($input);

        /**           COMMAND            */
        if (isset($input['message']['entities'][0]['type'])) {

            if ($input['message']['entities'][0]['type'] == TelegramConst::WEBHOOK_HANDLER_TYPE_COMMAND) {

                Log::info('Command : ' . TelegramConst::WEBHOOK_HANDLER_TYPE_COMMAND);

//                $this->bot->commandsHandler(true);
            }
        }



        /**            ACTIONS            */
        elseif (isset($input['callback_query']['data'])) {

            $data = json_decode($input['callback_query']['data']);

            if (in_array($data->action, config('telegram.actions.people'))) {

                $this->actionHandler($request, $data->action, $chatId);
            }
        }

        /**             MESSAGES          */
        elseif (isset($input['message']['text']))
        {
            $text = $input['message']['text'];

            $this->messageHandler($request, $text, $chatId);
        }
    }


    public function actionHandler(Request $request, string $action, int $chatId): void
    {
        $className = '\App\Socialite\Telegram\Webhook\Actions\\' . ucfirst($action);
        new $className($request, $chatId);
    }



    public function messageHandler(Request $request, string $text, int $chatId): void
    {
        $actions = [];
        $actions = array_merge($actions, config('telegram.keyboard.' . TelegramConst::WEBHOOK_MSG_ACT_ASSIST));
        $actions = array_merge($actions, config('telegram.keyboard.' . TelegramConst::WEBHOOK_MSG_ACT_PROJECTS));

        if (in_array($text, $actions)) {
            if (in_array($text,  config('telegram.keyboard.' . TelegramConst::WEBHOOK_MSG_ACT_ASSIST))) {
                $this->actionHandler($request, TelegramConst::WEBHOOK_PEOPLE_ACTION_ASSIST, $chatId);
            }
            elseif (in_array($text,  config('telegram.keyboard.' . TelegramConst::WEBHOOK_MSG_ACT_PROJECTS))) {
                $this->actionHandler($request, TelegramConst::WEBHOOK_PEOPLE_ACTION_PROJECTS, $chatId);
            }
        }
        else {
            $this->actionHandler($request, TelegramConst::WEBHOOK_PEOPLE_ACTION_SEARCH, $chatId);
        }
    }


    private function sendNotEnter()
    {
        $message = [
            'chat_id' => $this->chatId,
            'text' => __('Get start link please')
        ];
        $this->bot->sendMessage($message);
    }


    public function confirmPhoneButton($chat_id): array
    {
        $button = json_encode([
            "keyboard" => [[[
                "text" => __("Подтвердить Телефон"),
                'request_contact' => true
            ]]],
            'one_time_keyboard' => true,
            'resize_keyboard' => true,
        ], true);

        return array(
            'chat_id' => $chat_id,
            "text"    => __('Подтвердите Ваш телефон'),
            'reply_markup' => $button,
        );
    }
}
