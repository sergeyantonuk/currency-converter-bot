<?php

namespace App\Http\Services\Commands;

use App\Http\Services\ChatsService;
use App\Http\Services\CurrencyRatesService;

class CommandList extends Command
{
    protected $name = 'list';
    protected $description = 'Currencies list ';
    protected $aliases = ['lst'];
    protected $currencyRatesService;
    protected $chatsService;

    public function __construct(ChatsService $chatsService, CurrencyRatesService $currencyRatesService)
    {
        $this->currencyRatesService = $currencyRatesService;
        $this->chatsService = $chatsService;
    }

    function process($chat, $user, $commandParams = null)
    {
        $rates = $this->currencyRatesService->getCurrencyRates();

        $message = '';
        foreach ($rates as $rate) {
            $message .= $rate['name'] . ': ' . $rate['rateFormatted'] . "\n";
        }

        $this->chatsService->sendMessage($chat['id'], $message);
    }

    private function createUser($user)
    {
        return $this->usersService->createUser($user['id'], $user['username'], $user['first_name']);
    }

    private function createChat($userId, $chat)
    {
        return $this->chatsService->createChat($chat['id'], $userId);
    }
}