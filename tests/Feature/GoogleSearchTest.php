<?php

namespace Tests\Feature;

use App\Utils\SearchEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $searchEngine = new SearchEngine;
        $searchResult = $searchEngine->search('Google', 'Laravel');

        $this->assertNotEmpty($searchResult->getResults());
        $this->assertNotEmpty($searchResult->getLinks());
        $this->assertNotEmpty($searchResult->getHtml());
    }
}
