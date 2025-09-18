<?php

namespace App\Telegraph\Services;

use App\Models\Target;
use App\Models\TelegraphClient;
use App\Services\TargetHttpStatusChecker;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Stringable;

class TargetsService
{
    public function awaitTarget(TelegraphChat $chat, TelegraphClient $client): void
    {
        if (!$client->checkPlanLimit()) {
            $message = 'Trial limit achieved ('. $client->plan->limit . ' target).';
            $chat->message($message)->send();
            return;
        }

        $client->setAwait(1);
        $chat->message("Input target url")->send();
    }


    public function addTarget(TelegraphChat $chat, TelegraphClient $client, Stringable $text): void
    {
        if (!$client->checkPlanLimit()) {
            $message = 'Trial limit achieved ('. $client->plan->limit . ' target).';
            $chat->message($message)->send();
            return;
        }

        $result = TargetHttpStatusChecker::checkUrlComplex($text);

        if ($result['status']) {

            $tlgChat = TelegraphChat::where('chat_id', $chat->chat_id)->first();
            if (!$tlgChat) {
                $bot = TelegraphBot::find(1);
                $tlgChat = $bot->chats()->create([
                    'chat_id' => $chat->chat_id,
                    'name'    => $chat->name,
                    'locale'  => 'en',
                    'bot_id'  => 1
                ]);
            }

            $target = Target::create([
                'telegraph_client_id' => $client->id,
                'telegraph_chat_id'   => $tlgChat->id,
                'url'    => $text,
                'period' => Target::INTERVAL_DEFAULT,
                'active' => 1,
            ]);

            $message = $target ? 'Target was added' : 'Something wrong, try later';
            $client->setAwait(0);

            $chat->message($message)->send();
        }
        else {
            $message = $result['message'];
            $chat->message($message)->send();
        }
    }


    public function targets(TelegraphChat $chat, TelegraphClient $client)
    {
        $targets = $client->targets;

        if (!$targets->count()) {
            $chat->message("You dont have targets")->send();
            return;
        }

        $keyboard = Keyboard::make();

        foreach ($targets as $target) {
            $keyboard->row([
                Button::make($target->url)->action('show')->param('target_id', $target->id),
            ]);
        }

        $chat->message('Choose target from list')
            ->keyboard($keyboard)
            ->send();
    }


    public function control(TelegraphChat $chat, $targetId, TelegraphClient $client)
    {
        $target = Target::find($targetId);

        if ($target->telegraph_client_id !== $client->id) {
            $chat->message('You dont have access to this target!')
                ->send();
            return;
        }

        $keyboard = Keyboard::make();

        $keyboard->row([
            Button::make('Delete ' . $target->url)->action('delete')->param('target_id', $target->id),
        ]);

        if ($target->active) {
            $keyboard->row([
                Button::make('Stop watch ' . $target->url)->action('stopwatch')->param('target_id', $target->id),
            ]);
        } else {
            $keyboard->row([
                Button::make('Start watch ' . $target->url)->action('startwatch')->param('target_id', $target->id),
            ]);
        }

        $keyboard->row([
            Button::make('Check status ' . $target->url)->action('checkstatus')->param('target_id', $target->id),
        ]);

        $chat->message('Choose target action from list')
            ->keyboard($keyboard)
            ->send();
    }


    public function delete(TelegraphChat $chat, $targetId)
    {
        Target::destroy($targetId);
        $chat->message("Target was deleted")->send();
    }


    public function setActive(TelegraphChat $chat, $targetId, bool $active)
    {
        Target::setActive($targetId, $active);
        $status = $active ? ' active' : ' inactive';
        $chat->message("Target set " . $status)->send();
    }


    public function checkstatus(TelegraphChat $chat, $targetId)
    {
        $target = Target::find($targetId);
        $resultMessage = TargetHttpStatusChecker::checkUrlStatus($target->url);
        $chat->message($resultMessage)->send();
    }
}