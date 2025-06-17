<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MotorKApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.motork.url');
        $this->apiKey = config('services.motork.key');
    }

    public function getMakes(): array
    {
        $response = Http::get("{$this->baseUrl}/{$this->apiKey}/car/makes");
        return $response->json();
    }
}
