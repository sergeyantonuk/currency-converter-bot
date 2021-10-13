<?php

namespace App\Http\Services;

use App\Http\Services\TelegramApis\TelegramApiBotService;
use App\Chat;

class ChatsService
{
    private $telegramApiBotService;

    public function __construct(TelegramApiBotService $telegramApiBotService)
    {
        $this->telegramApiBotService = $telegramApiBotService;
    }

    public function createChat($chatId, $userId)
    {
        $chat = new Chat();
        $chat->id = $chatId;
        $chat->userId = $userId;
        $chat->save();

        return $chat;
    }

    public function sendMessage($chatId, $message)
    {
        $this->telegramApiBotService->sendMessage($chatId, $message);
    }

}