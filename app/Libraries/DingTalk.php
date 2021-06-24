<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Request;

class DingTalk
{
    public static function notice(string $message)
    {
        $postField = \json_encode(
            [
                'msgtype' => 'text',
                'text' => [
                    'content' => Request::fullUrl() . \PHP_EOL . \PHP_EOL . $message,
                ],
            ]
        );

        $curl = \curl_init();
        \curl_setopt_array($curl, [
            \CURLOPT_URL => 'https://oapi.dingtalk.com/robot/send?access_token=' . \config('app.ding_token'),
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_MAXREDIRS => 10,
            \CURLOPT_TIMEOUT => 1,
            \CURLOPT_FOLLOWLOCATION => true,
            \CURLOPT_CUSTOMREQUEST => 'POST',
            \CURLOPT_POSTFIELDS => $postField,
            \CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = \curl_exec($curl);
        \curl_close($curl);

        return \json_decode($response);
    }
}
