<?php
    
    
namespace App\Jobs;


use App\Helpers\TelegramConst;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Api;

class TelegramSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public array $text;

    public string $type;
    
    public string $group_name;
    
    public string $bot_name;
    
    public int $tries = 3;


    /**
     */
    public function __construct(
        array $text,
        string $type = 'info',
        string $group_name = TelegramConst::SREDA_GROUP_INFO,
        string $bot_name   = TelegramConst::SREDA_BOT_INFO
    )
    {
        $this->text       = $text;
        $this->type       = $type;
        $this->group_name = $group_name;
        $this->bot_name   = $bot_name;
    }


    /**
     * @return void
     */
    public function handle()
    {
        self::telegram_send_message();
    }


    /**
     * @return void
     */
    private function telegram_send_message()
    {
        /** define environment */
        $bot_name_end = $group_name_end = '';
        if (App::environment('dev') || App::environment('local')) {
            $bot_name_end = $group_name_end = 'Test';
        }

        /**  define  channel  */
        if ($this->type == 'error') {

            $this->group_name = TelegramConst::SREDA_GROUP_ERROR . $group_name_end;
            $this->bot_name   = TelegramConst::SREDA_BOT_ERROR . $bot_name_end;

        } elseif ($this->type == 'info') {

            $this->group_name = TelegramConst::SREDA_GROUP_INFO . $group_name_end;
            $this->bot_name   = TelegramConst::SREDA_BOT_INFO . $bot_name_end;
        }

        $this->send($this->bot_name, $this->group_name, $this->text);
    }


    /**
     * @param string $bot_name
     * @param string $group_name
     * @param array $text
     * @return void
     */
    private function send(string $bot_name, string $group_name, array $text)
    {
        $message = '';
        $message = $this->getMessagino($text, $message);

        try {

            $token = config('telegram.bots')[$bot_name]['token'];
            $telegram = new Api($token);
            $telegram->sendMessage([
                'chat_id' => config('telegram.group_ids')[$group_name],
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

        }
        catch (TelegramSDKException $e) {

            Log::error('Telegram failed: ' . $e->getMessage());

        }
        catch (\Exception $e) {

            Log::error('Telegram failed: ' . $e->getMessage());
        }
    }


    /**
     *  create message from data array recursively
     *
     * @param $text
     * @param $message
     * @return mixed|string
     */
    private function getMessagino($text, $message) {

        foreach ($text as $key => $val) {

            if (is_array($val)) {

                if (is_string($key)) {
                    $message .= $key . "\n";
                }

                $message = $this->getMessagino($val, $message);

            } else {

                if (is_numeric($key)) {

                    $message .= $val . " \n";

                } elseif (is_string($key)) {

                    $message .= "\n<b>$key:</b> " . $val . " \n";
                }
            }
        }

        return $message;
    }

}
