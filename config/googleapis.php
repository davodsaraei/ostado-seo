<?php

return [
    'query_suggestion' => [
        'base_url' => env('GOOGLE_APIS_CUSTOM_SEARCH_BASE_URL', 'https://suggestqueries.google.com/complete/search'),
        'client' => env('GOOGLE_APIS_CUSTOM_SEARCH_CLIENT', 'chrome'),
    ],
];