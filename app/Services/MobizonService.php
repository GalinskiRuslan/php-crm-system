<?php

namespace App\Services;

use Mobizon\MobizonApi;

class MobizonService
{


    protected $mobizon;

    public function __construct()
    {

        $apiHost = "http://api.mobizon.kz";
        $apiKey = config('services.mobizon.api_key');
        $this->mobizon = new MobizonApi($apiKey, $apiHost);
    }

    public function sendSms($recipient, $message)
    {
        $response = $this->mobizon->call(
            "http://api.mobizon.kz",
            'get',
            [
                'recipient' => $recipient,
                'text' => $message,
            ]
        );

        return $response;
    }
}
