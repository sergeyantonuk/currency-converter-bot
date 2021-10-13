<?php

namespace App\Providers;

use App\Http\Services\TelegramApis\TelegramApiClientService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\TelegramApiService;
use App\Http\Services\HttpClients as HttpClients;

class TelegramApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TelegramApiClientService::class, function ($app) {
            $httpClient = new HttpClients\GuzzleHttpClient();
            return new TelegramApiClientService($httpClient , config('app.telegram_api_key'));
        });

    }
}