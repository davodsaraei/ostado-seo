<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use App\Foundation\GoogleAPIs\QuerySuggestion;
use App\Foundation\GoogleAPIs\InvalidConfigException;

class QuerySuggestionTest extends TestCase
{
    public function test_when_base_url_config_not_set(): void
    {
        Config::set('googleapis.query_suggestion.base_url', null);

        $this->assertThrows(
            fn () => (new QuerySuggestion)->fetch('q'),
            InvalidConfigException::class
        );
    }

    public function test_when_client_config_not_set(): void
    {
        Config::set('googleapis.query_suggestion.client', null);

        $this->assertThrows(
            fn () => (new QuerySuggestion)->fetch('q'),
            InvalidConfigException::class
        );
    }

    public function test_when_config_not_set(): void
    {
        Config::set('googleapis.query_suggestion.base_url', null);
        Config::set('googleapis.query_suggestion.client', null);

        $this->assertThrows(
            fn () => (new QuerySuggestion)->fetch('q'),
            InvalidConfigException::class
        );
    }

    public function test_when_config_is_invalid(): void
    {
        Config::set('googleapis.query_suggestion.base_url', 'http://sample');
        Config::set('googleapis.query_suggestion.client', 'invalid');

        $result = (new QuerySuggestion)->fetch('q');

        $this->assertTrue($result->status === 0);
    }

    public function test_when_query_is_empty(): void
    {
        $queries = ['', null, '  '];

        foreach ($queries as $q) {
            $result = (new QuerySuggestion)->fetch($q);
            $this->assertTrue($result->status === 200 && count($result->items) === 0);
        }
    }

    public function test_when_query_is_zero(): void
    {
        $queries = [0, '0'];

        foreach ($queries as $q) {
            $result = (new QuerySuggestion)->fetch($q);
            $this->assertTrue($result->status === 200 && count($result->items) > 0);
        }
    }

    public function test_regular_query(): void
    {
        $queries = ['sample', 'how can i', 'learn test laravel', 'anythings'];

        foreach ($queries as $q) {
            $result = (new QuerySuggestion)->fetch($q);
            $this->assertTrue($result->status === 200 && count($result->items) > 0);
        }
    }
}
