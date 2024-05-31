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
        $client = new \GuzzleHttp\Client();
        $endpoint = "http://api.mobizon.kz/service/message/sendsmsmessage?text=$message&apiKey=kzed162ea83f13bdf624152ac71a28a07ddc3ac4f1260b8f48b10e999f429b86e3b026&recipient=+7$recipient&";
        $response = $client->request("GET", $endpoint);
        return $response->getBody()->getContents();
    }
}
