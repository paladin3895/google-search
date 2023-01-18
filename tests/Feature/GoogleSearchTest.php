<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\Search\GoogleSearch;
use Tests\TestCase;

class GoogleSearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search()
    {
        $searchTestPage = file_get_contents(base_path('/data/google-search-sample.html'));
        // Create a mock and queue several responses.
        $mock = new MockHandler([
            new Response(200, [], $searchTestPage),
            new Response(200, [], $searchTestPage),
            new Response(200, [], $searchTestPage),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handlerStack
            /* 'base_uri' => config('services.search_engine.search_urls.google'), */
        ]);

        $searchPage = (new GoogleSearch($client));
        $searchPage->performSearch('Laravel');

        $this->assertNotEmpty($searchPage->getResults());
        $this->assertNotEmpty($searchPage->getLinks());
        $this->assertNotEmpty($searchPage->getHtml());
    }
}
