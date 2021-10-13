<?php

namespace App\Http\Services\TelegramApis;

class TelegramApiRequest
{
    protected $httpMethod;
    protected $path;
    protected $params = [];

    public function __construct(
        $path,
        $httpMethod,
        array $params = []
    )
    {
        $this->setHttpMethod($httpMethod);
        $this->setPath($path);
        $this->setParams($params);
    }

    public function setHttpMethod(string $httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }


}