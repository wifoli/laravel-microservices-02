<?php

namespace App\Services;

use App\Services\Traits\ConsumeExternalService;
use Illuminate\Http\Client\Response;

class CompanyService
{
    use ConsumeExternalService;

    protected $token, $url;

    public function __construct()
    {
        $micro_01 = config('services.micro_01');
        $this->token = $micro_01['token'];
        $this->url = $micro_01['url'];
    }

    public function getCompany(string $company): Response
    {
        return $this->request(
            method: 'get',
            endpoint: "/companies/{$company}"
        );
    }
}
