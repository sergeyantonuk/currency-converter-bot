<?php

namespace App\Http\Services\TelegramApis;

class TelegramApiResponse
{
    protected $httpStatus;
    protected $body;
    protected $endpoint;


    public function __construct($response)
    {
        $this->httpStatus = $response['statusCode'];
        $this->setBody($response['body']);
    }

    public function isSuccess(): bool
    {
        $isStatusCodeSuccess = $this->httpStatus >= 200 && $this->httpStatus <= 299;
        $isBodySuccess = isset($this->body['ok']) && $this->body['ok'] === true;
        return $isStatusCodeSuccess && $isBodySuccess;
    }

    public function getHttpStatus(): string
    {
        return $this->httpStatus;
    }

    private function setBody(string $body)
    {
        $this->body = json_decode($body, true);
    }

    public function getBody()
    {
        return $this->body;
    }

}