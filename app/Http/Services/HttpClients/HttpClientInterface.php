<?php

namespace App\Http\Services\HttpClients;

interface HttpClientInterface {

    function request(
        string $url,
        string $method,
        array $params = [],
        array $headers = [],
        array $options = []
    );

}