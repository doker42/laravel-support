<?php

namespace App\Telegraph\Services;

use App\Telegraph\BotTrait;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;

class MenuService
{
    use BotTrait;
    public function startMenu(TelegraphChat $chat): void
    {
        $keyboard = Keyboard::make()
            ->row([
                Button::make($this->t('info'))->action('info'),
            ])
            ->row([
                Button::make($this->t('help'))->action('help'),
            ])
            ->row([
                Button::make('Profile')->action('profile'),
            ])
            ->row([
                Button::make($this->t('website'))->url('https://laravelsupport.ovh'),
//                Button::make('📞 Контакты')->action('contacts'),
//                Button::make('🌎 '.$this->t('choose_language'))->action('chooseLanguage'),
            ]);

        $chat->message($this->t('start'))
            ->keyboard($keyboard)
            ->send();
    }
}