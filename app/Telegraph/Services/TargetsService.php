<?php

namespace App\Telegraph\Services;

use App\Helpers\LogHelper;
use App\Models\Target;
use App\Models\TargetClient;
use App\Models\TelegraphClient;
use App\Services\TargetHttpStatusChecker;
use App\Services\TargetStatisticService;
use App\Telegraph\ClientMessages;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\DB;
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
            $chat->message('Your plan limit achieved (' . $client->plan->limit . ' target).')->send();
            return;
        }

        $isTargetClient = TargetClient::exists($text, $client);

        if ($isTargetClient) {
            $chat->message('Target already exists')->send();
            return;
        }

        $result = TargetHttpStatusChecker::checkUrlComplex($text);

        if (!$result['status']) {
            $chat->message($result['message'])->send();
            return;
        }

        DB::transaction(function () use ($chat, $client, $text) {

            $tlgChat = TelegraphChat::firstOrCreate(
                ['chat_id' => $chat->chat_id],
                [
                    'name'   => $chat->name,
                    'locale' => 'en',
                    'bot_id' => 1
                ]
            );

            $target = Target::firstOrCreate(
                ['url' => $text],
                [
                    'telegraph_client_id' => $client->id,
                    'telegraph_chat_id'   => $tlgChat->id,
                    'period'              => Target::INTERVAL_DEFAULT,
                    'active'              => 1,
                ]
            );

            TargetClient::firstOrCreate(
                [
                    'chat_id'              => $chat->chat_id,
                    'target_id'            => $target->id,
                    'telegraph_client_id'  => $client->id,
                ],
                ['active' => 1]
            );

            $client->setAwait(0);

            $chat->message('Target was added')->send();
            LogHelper::control('info', 'Target was added  Url: ' . $target->url);

        }, 2);
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
        $targetClient = TargetClient::get($targetId, $client->id);
        if (!$target || !$targetClient) {
            $chat->message('Sorry, there is wrong data!')
                ->send();
            return;
        }

        $clientsIdsArr = $target->clients()->pluck('telegraph_client_id')->toArray();

        if (count($clientsIdsArr) && !in_array($client->id, $clientsIdsArr)) {
            $chat->message('You dont have access to this target!')
                ->send();
            return;
        }

        $keyboard = Keyboard::make();

        $keyboard->row([
            Button::make('Set Interval ' . $target->url)->action('set_interval')->param('target_id', $target->id),
        ]);

        $keyboard->row([
            Button::make('Delete ' . $target->url)->action('delete')->param('target_id', $target->id),
        ]);

        if ($targetClient->active) {
            $keyboard->row([
                Button::make('Stop watch ' . $target->url)->action('stop_watch')->param('target_id', $target->id),
            ]);
        } else {
            $keyboard->row([
                Button::make('Start watch ' . $target->url)->action('start_watch')->param('target_id', $target->id),
            ]);
        }

        $keyboard->row([
            Button::make('Check target status')->action('check_status')->param('target_id', $target->id),
        ]);

        $keyboard->row([
            Button::make('Get target statistic')->action('select_period')->param('target_id', $target->id),
        ]);

        $keyboard->row([
            Button::make('Get test down message')->action('test_down_message')->param('target_id', $target->id),
        ]);

        $chat->message('Choose target action from list')
            ->keyboard($keyboard)
            ->send();
    }


    public function selectPeriod(TelegraphChat $chat, $targetId)
    {
        $keyboard = Keyboard::make();

        $periods = [7, 30, 60];
        foreach ($periods as $days) {
            $keyboard->row([
                Button::make($days . ' days')->action('get_statistic')->param('target_id', $targetId)->param('days', $days),
            ]);
        }

        $chat->message('Select period for status:')
            ->keyboard($keyboard)
            ->send();
    }


    public function setInterval(TelegraphChat $chat, $targetId, TelegraphClient $client)
    {
        $intervals = json_decode($client->plan->intervals);

        $keyboard = Keyboard::make();

        foreach ($intervals as $interval) {
            $keyboard->row([
                Button::make($interval . ' sec.')
                ->action('store_interval')
                ->param('target_id', $targetId)
                ->param('interval', $interval),
            ]);
        }

        $chat->message('Choose interval')
            ->keyboard($keyboard)
            ->send();
    }


    public function storeInterval(TelegraphChat $chat, $targetId, TelegraphClient $client, $interval)
    {
        $targetClient = TargetClient::get($targetId, $client->id);
        $targetClient->update([
            'interval' => $interval
        ]);
        $chat->message("Target interval set " . $interval)->send();
    }


    public function delete(TelegraphChat $chat, $targetId, TelegraphClient $client)
    {
        $telegraphClientId = $client->id;
        TargetClient::remove($targetId, $telegraphClientId);
        $chat->message("Target was deleted")->send();
    }


    public function setActive(TelegraphChat $chat, $targetId, TelegraphClient $client, bool $active)
    {
        $clientId = $client->id;
        TargetClient::setActive($targetId, $clientId, $active);
        $status = $active ? ' active' : ' inactive';
        $chat->message("Target set " . $status)->send();
    }


    public function checkstatus(TelegraphChat $chat, $targetId)
    {
        $target = Target::find($targetId);
        $resultMessage = TargetHttpStatusChecker::checkUrlStatus($target->url);
        $chat->message($resultMessage)->send();
    }


    public function getStatistic(TelegraphChat $chat, $targetId, int $days): void
    {
        $target = Target::find($targetId);
        $targetStatuses = TargetStatisticService::statusesByDays($target, $days);
        $message = ClientMessages::targetStatistic($targetStatuses);
        $chat->message($message)->send();
    }


    public function testTargetDownMessage(TelegraphChat $chat, $targetId): void
    {
        $target = Target::find($targetId);
        $message = ClientMessages::targetDown($target, '404');
        $chat->message($message)->send();
    }

}