<?php

namespace App\Messengers\Telegram\Commands;

use App\Helpers\TelegramConst;
use App\Messengers\Telegram\Buttons\InlineButton;
use App\Socialite\Telegram\Buttons\KeyboardButton;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Commands\Command;


class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected string $name = 'start';

    /**
     * @var array Command Aliases
     */
    protected array $aliases = ['start-alias'];

    /**
     * @var string Command Description
     */
    protected string $description = 'Start work with client';



    public function handle(): void
    {
        $update = $this->getUpdate();
        $chatId = $update->getChat()?->get('id');
        $text = $update->getMessage()->get('text');
        $payload = explode(' ', $text);
        $token = !empty($payload[1])
                 ? $payload[1]
                 : null;

//        if ($token) {
//
//            $messengerClient = MessengerClient::where('token', $token)->first();
//
//            if ($messengerClient) {
//
//                MessengerClient::where('messenger_id', $messenger->id)
//                    ->where('token', '!=', $token)
//                    ->where('chat_id', $chatId)
//                    ->delete();
//
//
//                $messengerClient->token   = Str::random(30);
//                $messengerClient->data    = null;
//                $messengerClient->chat_id = $chatId;
//                $messengerClient->save();
//
//                $person = $messengerClient->person();
//
//                if ($person) {
//                    App::setLocale($person->language);
//                    $this->startPersonInline($person, $messengerClient);
//                    $this->startPerson($person);
//                }
//                else {
//                    $this->replyWithMessage(['text' => __('Sorry, cant find person')]);
//                }
//            }
//            else {
//                $this->replyWithMessage(['text' => __('Sorry, try get new link')]);
//            }
//        }
//        else {
//
//            $messengerClient = MessengerClient::where('messenger_id', $messenger->id)
//                ->where('chat_id', $chatId)
//                ->first();
//
//            if ($messengerClient) {
//
//                if ($messengerClient->data) {
//                    $messengerClient->data = null;
//                    $messengerClient->save();
//                }
//
//                $person = $messengerClient->person();
//
//                if ($person) {
//
//                    $this->startPersonInline($person, $messengerClient);
//                    $this->startPerson($person);
//
//                    return;
//                }
//            }
//            $this->replyWithMessage(['text' => __('Sorry, try get new link')]);
//        }
    }



//    private function startPerson(Person $person): void
//    {
//        $personProjectsActive = $person->projectPersonsActive();
//        $countProjects = count($personProjectsActive);
//
//        if ($countProjects) {
//
//            if ($countProjects > 1) {
//
//                KeyboardButton::add(__(TelegramConst::WEBHOOK_MSG_ACT_PROJECTS), 1);
//            }
//        }
//
//        KeyboardButton::add(__(TelegramConst::WEBHOOK_MSG_ACT_ASSIST), 1);
//
//        $message = [
//            'text' => __(':name, choose button',['name' => $person->name]),
//            'reply_markup' => json_encode(KeyboardButton::$buttons),
//        ];
//
//        $this->replyWithMessage($message);
//    }



//    private function startPersonInline(Person $person, MessengerClient $messengerClient): void
//    {
//        $personProjectsActive = $person->projectPersonsActive();
//        $countProjects = count($personProjectsActive);
//
//        if ($countProjects) {
//
//            if ($countProjects > 1) {
//
//                $data = [
//                    'id'   => $messengerClient->current_project_id,
//                    'cur'  => 1,
//                ];
//
//               InlineButton::add(__(TelegramConst::WEBHOOK_MSG_ACT_PROJECTS), 'projects', $data, 1);
//            }
//        }
//
//        $data = [
//            'id'   => $messengerClient->current_project_id,
//            'cur'  => 1,
//        ];
//
//        InlineButton::add(__(TelegramConst::WEBHOOK_MSG_ACT_ASSIST), 'assist', $data, 1);
//
//        $message = [
//            'text' => __('Hello :name! Choose action', ['name' => $person->name]),
//            'reply_markup' => json_encode(InlineButton::$buttons),
//        ];
//
//        $this->replyWithMessage($message);
//    }
}
