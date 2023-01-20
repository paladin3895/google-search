<?php

namespace App\Services\Search;

/**
 * Interface SearchInterface
 * @author Dat Pham
 */
interface SearchInterface
{
    public function performSearch(string $keyword): void;

    public function getResults(): string;

    public function getAdwords(): array;

    public function getLinks(): array;

    public function getHtml(): string;

}
