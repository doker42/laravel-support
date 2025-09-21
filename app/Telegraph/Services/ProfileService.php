<?php

namespace App\Telegraph\Services;

use App\Models\TelegraphClient;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;

class ProfileService
{
    public function show(TelegraphChat $chat, TelegraphClient $client)
    {
        $keyboard = Keyboard::make()
            ->row([
                Button::make('Your Plan')->action('plan'),
            ]);
//            ->row([
//                Button::make('Settings')->action('settings'),
//            ]);

        $chat->message('Profile')
            ->keyboard($keyboard)
            ->send();
    }


    public function plan(TelegraphChat $chat, TelegraphClient $client)
    {
        $plan = $client->plan;
        $status = $plan->active ? '✅ <b>Active</b>' : '❌ <b>Inactive</b>';

        $message = <<<HTML
            <b>📋 Your Subscription Plan</b>
            
            <b>Title:</b> {$plan->title}
            <b>Limit:</b> {$plan->limit}
            <b>Watch Period:</b> {$plan->interval} sec
            <b>Status:</b> {$status}
            <b>Subscription until:</b> {$client->end_subscription}
            HTML;

        $chat->html($message)
            ->keyboard(
                Keyboard::make()->row([
                    Button::make('🔄 Renew Plan')
                        ->action('renew')
                        ->param('plan_id', $plan->id),
                ])
        )
            ->send();
    }


    public function settings(TelegraphChat $chat, TelegraphClient $client)
    {
        $keyboard = Keyboard::make()
            ->row([
                Button::make('choose_language')->action('chooseLanguage'),
            ]);

        $chat->message('Settings')
            ->keyboard($keyboard)
            ->send();
    }
}