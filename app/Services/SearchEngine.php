<?php

namespace App\Services;

use InvalidArgumentException;
use GuzzleHttp\Client;
use App\Services\Search\GoogleSearch;
use App\Services\Search\SearchInterface;

/**
 * Class SearchEngine
 * this is a search engine factory
 * @author Dat Pham
 */
class SearchEngine
{
    /**
     * undocumented function
     *
     * @return SearchInterface
     */
    public function search($type, $query): SearchInterface
    {
        switch ($type) {
            case 'Google':
                $client = new Client([
                    'base_uri' => config('services.search_engine.search_urls.google'),
                ]);

                $searchPage = new GoogleSearch($client);
                $searchPage->performSearch($query);
                return $searchPage;
            default:
                throw new InvalidArgumentException('Invalid search engine');
        }
    }
}
