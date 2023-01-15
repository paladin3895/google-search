<?php

namespace App\Utils;

use App\Utils\Search\GoogleSearch;
use App\Utils\Search\SearchInterface;
use InvalidArgumentException;

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
                return new GoogleSearch($query);
            default:
                throw new InvalidArgumentException('Invalid search engine');
        }
    }
}
