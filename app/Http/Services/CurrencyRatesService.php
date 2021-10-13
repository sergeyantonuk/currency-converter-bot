<?php

namespace App\Http\Services;

use Log;
use App\CurrencyRate;
use App\Http\Services\HttpClients\GuzzleHttpClient;

class CurrencyRatesService
{
    private $currencyRateModel;
    private $guzzleHttpClient;
    private $currencyRateDecimals;
    private $baseCurrency;

    function __construct(CurrencyRate $currencyRateModel, GuzzleHttpClient $guzzleHttpClient)
    {
        $this->currencyRateModel = $currencyRateModel;
        $this->guzzleHttpClient = $guzzleHttpClient;
        $this->currencyRateDecimals = config('app.currency_rate_decimals');
        $this->baseCurrency = config('app.base_currency');
    }


    public function getCurrencyRates()
    {
        return CurrencyRate::all();
    }

    public function getCurrencyRate($currency)
    {
        return CurrencyRate::where('name', $currency)->first();
    }

    public function exchange($source, $target)
    {
        $sourceCurrencyRate = $this->getCurrencyRate($source['currency']);
        $targetCurrencyRate = $this->getCurrencyRate($target['currency']);

        if ($this->isBaseCurrency($source['currency'])) {
            $exchangedAmount = (float)$source['amount'] * (float)$targetCurrencyRate['rate'];

        } elseif ($this->isBaseCurrency($target['currency'])) {
            $exchangedAmount = (float)$source['amount'] / (float)$sourceCurrencyRate['rate'];

        } else {
            $exchangedAmount = (float)$source['amount'] / (float)$sourceCurrencyRate['rate'] * (float)$targetCurrencyRate['rate'];
        }

        $exchangedAmountFormatted = number_format($exchangedAmount, $this->currencyRateDecimals, '.', '');

        if ($exchangedAmountFormatted == 0) {
            return $exchangedAmount;
        }
        return $exchangedAmountFormatted;
    }

    public function getCurrencyRatesFromApi()
    {
        $exchangeRatesApiKey = config('app.exchange_rates_api_key');
        $baseUrl = 'http://api.exchangeratesapi.io/v1/latest';
        $requestUrl = $baseUrl . '?access_key=' . $exchangeRatesApiKey . '&base=' . $this->baseCurrency;

        $response = $this->guzzleHttpClient->request($requestUrl, 'GET');

        if ($response['statusCode'] === 200) {
            return json_decode($response['body'])->rates;
        }

        Log::info('CurrencyRatesService->getCurrencyRatesFromApi()->rates have not been updated',
            ['response->statusCode' => $response['statusCode']]
        );
    }

    public function isBaseCurrency($currencyName)
    {
        if ($currencyName === $this->baseCurrency) {
            return true;
        }
        return false;
    }

    public function updateCurrencyRatesDb($currencyRates)
    {

        foreach ($currencyRates as $currency => $rate) {

            CurrencyRate::updateOrCreate(
                ['name' => $currency],
                ['rate' => $rate]
            );
        }
    }

    public function test()
    {
        return 'test';
    }
}