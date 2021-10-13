<?php

namespace App\Http\Services\Commands;

use App\Http\Services\ChatsService;
use App\Http\Services\CurrencyRatesService;

class CommandExchange extends Command
{
    protected $name = 'exchange';
    protected $description = 'Exchange currency';
    protected $currencyRatesService;
    protected $chatsService;

    public function __construct(ChatsService $chatsService, CurrencyRatesService $currencyRatesService)
    {
        $this->currencyRatesService = $currencyRatesService;
        $this->chatsService = $chatsService;
    }

    function process($chat, $user, $commandParams = null)
    {
        $exchangeParams = $this->parseCommandParams($commandParams);
        if (!$this->validateCommandParams($exchangeParams)) {
            $this->chatsService->sendMessage($chat['id'], 'Check your params');
            throw new CommandException('Command params are wrong');
        }
        $exchangedAmount = $this->currencyRatesService->exchange($exchangeParams['source'], $exchangeParams['target']);

        $message = $exchangedAmount . ' ' . $exchangeParams['target']['currency'];
        $this->chatsService->sendMessage($chat['id'], $message);
    }

    private function validateCommandParams($params)
    {
        $source = $params['source'];
        $target = $params['target'];

        if (!$source['currency'] || !$source['amount']) {
            return false;
        }

        if (!$target['currency']) {
            return false;
        }

        return true;
    }

    private function parseCommandParams($params)
    {
        $matches = [];

        preg_match('/([0-9]+)[\ ]*([a-z]+)\ to ([a-z]+)/i', $params, $matches);

        $source = ['currency' => $matches[2] ?? null, 'amount' => $matches[1] ?? null];
        $target = ['currency' => $matches[3] ?? null, 'amount' => $matches[4] ?? null];

        return ['source' => $source, 'target' => $target];
    }
}