<?php

namespace App\Telegraph;

use App\Models\Setting;
use App\Models\TelegraphClient;
use App\Telegraph\Commands\MenuCommand;
use App\Telegraph\Commands\StartCommand;
use App\Telegraph\Commands\TargetsCommand;
use App\Telegraph\Services\ProfileService;
use App\Telegraph\Services\TargetsService;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class BotHandler extends WebhookHandler
{
    private ?TelegraphClient $client = null;

    protected function handleMessage(): void
    {
        if (!Setting::botEnabled()) {
            $this->reply("🚧 ". __('The service is temporarily unavailable.'));
            return;
        }

        parent::handleMessage();
    }


    protected function client(): ?TelegraphClient
    {
        if ($this->client === null && $this->chat !== null) {
            $this->client = TelegraphClient::getClientByChat($this->chat);
            if (!$this->client) {
                $this->reply('No Client!');
            }
        }

        return $this->client;
    }

    public function start(): void
    {
        $this->client();
        app(StartCommand::class)($this->chat);
    }

    public function menu(): void
    {
        app(MenuCommand::class)($this->chat);
    }

    public function add(): void
    {
        app(TargetsService::class)->awaitTarget($this->chat, $this->client());
    }

    public function info(): void
    {
        $message = <<<HTML
            <b>ℹ️ I am bot - site-watcher</b>
            I can control your site availability.
            If your site will down I will send you a message about it
            HTML;

        $this->chat->html($message)->send();
    }

    public function targets(): void
    {
        TargetsCommand::handle($this->chat, $this->client());
    }

    public function show(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->control($this->chat, $targetId, $this->client());
    }

    public function set_interval(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->setInterval($this->chat, $targetId, $this->client());
    }

    public function store_interval()
    {
        $targetId = $this->data->get('target_id');
        $interval = $this->data->get('interval');
        app(TargetsService::class)->storeInterval($this->chat, $targetId, $this->client(), $interval);
    }

    public function delete(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->delete($this->chat, $targetId, $this->client());
    }

    public function stop_watch(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->setActive($this->chat, $targetId, $this->client(), false);
    }

    public function start_watch(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->setActive($this->chat, $targetId, $this->client(), true);
    }

    public function stop_target_client_inform(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->setTargetClientInform($this->chat, $targetId, $this->client(), false);
    }

    public function start_target_client_inform(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->setTargetClientInform($this->chat, $targetId, $this->client(), true);
    }

    public function check_status(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->checkstatus($this->chat, $targetId);
    }

    public function select_period(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->selectPeriod($this->chat, $targetId);
    }

    public function get_statistic(): void
    {
        $targetId = $this->data->get('target_id');
        $days = $this->data->get('days');
        app(TargetsService::class)->getStatistic($this->chat, $targetId, $days);
    }

    public function test_down_message(): void
    {
        $targetId = $this->data->get('target_id');
        app(TargetsService::class)->testTargetDownMessage($this->chat, $targetId);
    }

    public function profile(): void
    {
        app(ProfileService::class)->show($this->chat, $this->client());
    }

    public function settings(): void
    {
        app(ProfileService::class)->settings($this->chat, $this->client());
    }

    public function plan(): void
    {
        app(ProfileService::class)->plan($this->chat, $this->client());
    }

    public function renew(): void
    {
        $this->reply('functionality in development');
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $client = $this->client();

        if ($client->await) {
            app(TargetsService::class)->addTarget($this->chat, $client, $text);
            return;
        }

        $this->reply('Input command');
    }










    public function help(): void
    {
        $this->chat->message("Command list:\n/start - start work\n/menu - menu\n/info  - about\n/targets - targets list\n/add  - add target")->send();
    }
    public function contacts(): void
    {
        $this->chat->message("📞 Свяжитесь с нами: contact@example.com")->send();
    }
    public function chooseLanguage(): void
    {
        $keyboard = Keyboard::make()
            ->row([
                Button::make('🇺🇦 Українська')->action('setLocale_uk'),
                Button::make('🇷🇺 Русский')->action('setLocale_ru'),
                Button::make('🇺🇸 English')->action('setLocale_en'),
            ]);

        $this->chat->message($this->t('choose_language'))
            ->keyboard($keyboard)
            ->send();
    }
    public function setLocale_uk(): void
    {
        $this->chat->update(['locale' => 'uk']);
        App::setLocale('uk');
        $this->chat->message("✅ Мову змінено на українську")->send();
        $this->start(); // можно показать главное меню на выбранном языке
    }
    public function setLocale_ru(): void
    {
        $this->chat->update(['locale' => 'ru']);
        App::setLocale('ru');
        $this->chat->message("✅ Язык изменён на русский")->send();
        $this->start(); // можно показать главное меню на выбранном языке
    }
    public function setLocale_en(): void
    {
        $this->chat->update(['locale' => 'en']);
        App::setLocale('en');
        $this->chat->message("✅ Language changed to English")->send();
        $this->start();
    }
    protected function handleUnknownCommand(\Illuminate\Support\Stringable $text): void
    {
//        if ($text->value() == '/start') {
//            $this->reply('Pay attention!');
//        } else {
            $this->reply('UnknownCommand');
//        }
    }

//    public function callback(string $callbackData): void
//    {
//        switch ($callbackData) {
//            case 'about':
//                $this->chat->message("ℹ️ I am a bot Site Watcher")->send();
//                break;
//            case 'help':
//                $this->chat->message("❓ Command list:\n/start - menu\n/info - about\n/targets - targets list\n/add - add target")->send();
//                break;
//            default:
//                $this->chat->message("⚠️ Default btn")->send();
//                break;
//        }
//    }


    protected function t(string $key): string
    {
//        $locale = $this->chat->locale ?? config('app.locale'); // берем локаль чата или дефолт
        $locale = App::getLocale() ?? config('app.locale'); // берем локаль чата или дефолт

        Log::info('locale '. $locale);

        return trans("messages.$key", [], $locale);
    }
}