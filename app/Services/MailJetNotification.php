<?php

namespace App\Services;

use Mailjet\Resources;

class MailJetNotification
{
    public static function handle(array $data)
    {
        self::sendMail($data);
    }

    public static function sendMail(array $data)
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
                    'HTMLPart' => "<h3>Contact!</h3><p>". $data['email'] . " message: " . $data['message'] . "</p>"
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