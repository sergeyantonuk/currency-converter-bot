<?php

namespace App\Http\Services\TelegramApis;

use GuzzleHttp\Client;
use App\Http\Services;
use App\Http\Services\HttpClients\HttpClientInterface;

/*
 * Low level API service
 *
 * Responsible for doing raw requests to the API, auth and error handling
 *
 * Any other specific telegram API's may be built on top of this
 */

class TelegramApiClientService
{
    private $telegramApiKey;
    private $baseUrl;
    private $httpClient;

    function __construct(HttpClientInterface $httpClient, $telegramApiKey)
    {
        $this->telegramApiKey = $telegramApiKey;
        $this->baseUrl = 'https://api.telegram.org/bot' . $this->telegramApiKey . '/';
        $this->httpClient = $httpClient;
    }

    function request(TelegramApiRequest $request): TelegramApiResponse
    {
        $url = $this->baseUrl . $request->getPath();
        $response = $this->httpClient->request($url, $request->getHttpMethod(), $request->getParams());

        $statusCode = $response['statusCode'];

        if ($statusCode >= 200 && $statusCode <= 299) {
            return new TelegramApiResponse($response);
        }
    }

}