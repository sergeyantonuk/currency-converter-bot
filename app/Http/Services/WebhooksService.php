<?php

namespace App\Http\Services;

use App\Http\Services\Commands\CommandsManagerService;

class WebhooksService
{

    private $commandsManagerService;

    public function __construct(CommandsManagerService $commandsManagerService)
    {
        $this->commandsManagerService = $commandsManagerService;
    }

    public function processWebhook($message, $chat, $user)
    {
        $parsedCommand = $this->commandsManagerService->parseCommand($message);

        return $this->commandsManagerService->processCommand($chat, $user, $parsedCommand['command'], $parsedCommand['params']);
    }


}