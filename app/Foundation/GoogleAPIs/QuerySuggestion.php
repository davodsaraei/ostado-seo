<?php

namespace App\Foundation\GoogleAPIs;

use Illuminate\Support\Facades\Http;
use App\Foundation\GoogleAPIs\InvalidConfigException;

class querySuggestion
{
    private $baseUrl;
    private $client;
    private $cx;

    public function __construct()
    {
        $this->baseUrl = config('googleapis.query_suggestion.base_url');
        $this->client = config('googleapis.query_suggestion.client');

        throw_if(! ($this->baseUrl && $this->client), InvalidConfigException::class);
    }

    public function fetch(string $q)
    {
        $query = [
            'client' => $this->client,
            'q' => $q,
        ];
        $url = $this->baseUrl;

        try {
            $response = Http::acceptJson()->get($url, $query);
        } catch (\Exception $e) {
            return (object) [
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
                'errors' => [],
            ];
        }

        if ($response->status() !== 200) {
            return (object) [
                'status' => $response->status(),
                'message' => $response->json('message'),
                'errors' => $response->json('errors'),
            ];
        }

        $items = $response->collect()[1] ?? [];

        return (object) [
            'status' => 200,
            'items' => $items
        ];
    }
}