<?php

namespace App\Http\Services\Commands;

use Log;
use App\Http\Services\ChatsService;
use App\Http\Services\TelegramApis\TelegramApiClientService;
use App\Http\Services\UsersService;

class CommandStart extends Command {

    protected $name = 'start';
    protected $description = 'Start using bot';
    protected $chatsService;
    protected $usersService;

    public function __construct(ChatsService $chatsService, UsersService $usersService)
    {
        $this->chatsService = $chatsService;
        $this->usersService = $usersService;
    }

    function process($chat, $user, $commandParams = null) {

        Log::info('CommandStart->process:', ['$chat' => $chat, '$user' => $user, '$commandParams' => $commandParams]);

        $telegramUserId = $user['id'];

        $userDb = $this->usersService->getUserByTelegramUserId($telegramUserId);

        if (!$userDb) {
            $user = $this->createUser($user);

            $this->createChat($user->id, $chat);
        }

        $this->chatsService->sendMessage($telegramUserId, 'Hi. This is currency bot');
    }

    private function createUser($user) {
        return $this->usersService->createUser($user['id'], $user['username'], $user['first_name'] );
    }

    private function createChat($userId, $chat) {
        return $this->chatsService->createChat($chat['id'], $userId);
    }
}