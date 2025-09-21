<?php

namespace App\Models;

use App\Services\TelegramNotifier;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TelegraphClient extends Model
{
    protected $fillable = [
        'telegraph_chat_id',
        'chat_id',
        'plan_id',
        'await',
        'name',
        'end_subscription'
    ];

    public static function getClientByMessage($message)
    {
        $from = $message->from();
        $chat_id = $from->id();
        $client = self::where('chat_id',$chat_id)->first();

        if (!$client) {
            $client = self::create([
                'chat_id' => $chat_id,
                'name'    => $from?->username(),
            ]);
        }

        return $client;
    }

    public static function getClientByChat(TelegraphChat $chat)
    {
        $chat_id = $chat->chat_id;
        $client = self::where('chat_id',$chat_id)->first();
        $planTestFree = Plan::find(1);

        $tlgChat = TelegraphChat::where('chat_id', $chat_id)->first();
        if (!$tlgChat) {
            $bot = TelegraphBot::find(1);
            $chat = $bot->chats()->create([
//                'telegraph_chat_id' => $tlgChat?->id,
                'chat_id' => $chat_id,
                'name'    => self::getChatName($chat),
                'locale'  => 'en'
            ]);
        }

        if (!$client) {
            $client = self::create([
//                'telegraph_chat_id' => $tlgChat?->id,
                'chat_id' => $chat_id,
                'name'    => self::getChatName($chat),
                'end_subscription' => Carbon::now()->addDays($planTestFree->duration)->format('Y-m-d'),
            ]);

            if ($client) {
                TelegramNotifier::log([
                    'text' => 'New client',
                    'message' => 'you have a new client',
                ]);
            }

        }

        return $client;
    }


    public static function getChatName(TelegraphChat $chat)
    {
        $chatInfo = $chat->info();
        $first_name = $chatInfo['first_name'];
        return $first_name ?: "NonameClient";
    }


    public function getName()
    {
        return $this->name ? $this->escapeTelegram($this->name) : "NonameClient";
    }

    public function escapeTelegram(string $text): string
    {
        // Список символов, которые нужно экранировать для MarkdownV2
        $specialChars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];

        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\'.$char, $text);
        }

        return $text;
    }


    /**
     * Установить значение await
     *
     * @param int $value
     * @return $this
     */
    public function setAwait(int $value): self
    {
        $this->await = $value;
        $this->save();
        return $this;
    }


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

//    public function targets()
//    {
//        return $this->hasMany(Target::class);
//    }

    public function targets()
    {
        return $this->belongsToMany(Target::class, 'target_client', 'telegraph_client_id','target_id');
    }


    public function checkPlanLimit(): bool
    {
        return $this->plan->limit > $this->targets->count();
    }
}
