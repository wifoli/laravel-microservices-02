<?php

namespace App\Services\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait ConsumeExternalService
{
    private function headers(array $headers = [])
    {
        array_push($headers, [
            'Accept'        => 'application/json',
            'Authorization' => $this->token,
        ]);

        return Http::withHeaders($headers);
    }

    public function request(
        string $method,
        string $endpoint,
        array $formParams = [],
        array $headers = []
    ): Response {
        return $this->headers($headers)
            ->$method($this->url . $endpoint, $formParams);
    }
}
