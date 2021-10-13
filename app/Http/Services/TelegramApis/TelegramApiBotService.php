<?php

namespace App\Http\Services\TelegramApis;

/*
 * Telegram Bot API service
 *
 * Provides interface over Telegram Bot API
 *
 * Utilizes TelegramApiService as low level utility
 */

use App\Http\Services;

class TelegramApiBotService extends TelegramApiBaseService
{
    private $telegramApiClient;

    function __construct(TelegramApiClientService $telegramApiClientService)
    {
        $this->telegramApiClient = $telegramApiClientService;
    }

    function getMe()
    {
        $path = 'getMe';

        $request = new TelegramApiRequest($path, 'GET');
        return $this->telegramApiClient->request($request);
    }

    function getUpdates()
    {
        $path = 'getUpdates';

        $request = new TelegramApiRequest($path, 'GET');
        return $this->telegramApiClient->request($request);
    }

    function sendMessage($chat_id, $message)
    {
        $path = 'sendMessage';
        $params = [
            'chat_id' => $chat_id,
            'text' => $message,
        ];

        $request = new TelegramApiRequest($path, 'POST', $params);
        return $this->telegramApiClient->request($request);
    }

    public function setMyCommands($commands, $scope)
    {
        $path = 'setMyCommands';
        $params = ['commands' => $commands];

        $request = new TelegramApiRequest($path, 'POST', $params);

        return $this->telegramApiClient->request($request);
    }
}