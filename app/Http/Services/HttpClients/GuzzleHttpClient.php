<?php


namespace App\Http\Services\HttpClients;

use App\Http\Contractsx\TestInterface;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Services\HttpClients;
use TelegramApi\Exceptions\TelegramApiException;
use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    function request(
        string $url,
        string $method,
        array $params = [],
        array $headers = [],
        array $options = []
    )
    {
        try {
            $r = $this->client->request($method, $url, ['headers' => $headers, 'form_params' => $params]);

            return [
                'body' => (string)$r->getBody(),
                'statusCode' => $r->getStatusCode(),
                'headers' => $r->getHeaders(),
            ];
        } catch (GuzzleException $e) {
            throw new HttpClientException($e);
        }
    }
}