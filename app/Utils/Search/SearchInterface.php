<?php

namespace App\Utils\Search;

/**
 * Interface SearchInterface
 * @author Dat Pham
 */
interface SearchInterface
{
    public function getResults(): string;

    public function getAdwords(): array;

    public function getLinks(): array;

    public function getHtml(): string;

}
