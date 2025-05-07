<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mailjet\Resources;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.landing');
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Отправка email (если нужно)
        $resMail = $this->sendMail($data) ? "Success" : "Failed";

        // Отправка в Telegram
        $message = "📬 New Contact Request:\n\n"
            . "👤 Name: {$data['name']}\n"
            . "✉️ Email: {$data['email']}\n"
            . "📝 Message:\n{$data['message']}\n"
            . " email_sendind: {$resMail}";

        $token = env('TELEGRAM_BOT_TOKEN');
        $chat_id = env('TELEGRAM_CHAT_ID');


        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chat_id,
            'text'    => $message,
        ]);

        return back()->with('success', 'Message sent!');
    }

    public function sendMail(array $data)
    {
        $apiKey    = env('MAILJET_API_KEY');
        $secretKey = env('MAILJET_SECRET_KEY');

        if (!$apiKey || !$secretKey) {
            return false;
        }

        $mj = new \Mailjet\Client($apiKey, $secretKey, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => 'doker42@gmail.com',
                        'Name'  => $data['name'],
                    ],
                    'To' => [
                        [
                            'Email' => env('MAIL_TO'),
                            'Name'  => "laravelSupport"
                        ]
                    ],
                    'Subject' => "laravelSupport",
                    'TextPart' => "Это текстовое письмо",
                    'HTMLPart' => "<h3>Congrads!</h3><p>". $data['email'] . " message: " . $data['message'] . "</p>"
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);

//        if ($response->success()) {
//            Log::info( "Успешно отправлено!");
//        } else {
//            Log::info($response->getStatus());
//            Log::info($response->getData());
//        }

        return (bool) $response->success();

    }
}


