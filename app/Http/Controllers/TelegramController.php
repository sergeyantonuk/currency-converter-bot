<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Commands\CommandException;
use TelegramApi\Exceptions\TelegramApiException;
use App\Http\Services\TelegramApis\TelegramApiBotService;
use App\Http\Services\Commands\CommandsManagerService;
use App\Http\Requests\TelegramWebhookRequest;
use App\Http\Services\WebhooksService;


class TelegramController extends Controller
{
    private $webhooksService;

    public function __construct(WebhooksService $webhooksService)
    {
        $this->webhooksService = $webhooksService;
    }

    function webhook(TelegramWebhookRequest $request)
    {
        $message = $request->validated()['message'];

        $response = [];

        try {
            $response = $this->webhooksService->processWebhook($message['text'], $message['chat'], $message['from']);
        } catch (CommandException $e) {
            return response()->json(null, 200);
        } catch (TelegramApiException $e) {
            return response()->json(null, 200);
        }

        return response()->json($response, 200);
    }
}