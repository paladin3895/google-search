<?php

namespace App\Services\Search;

use DOMDocument;
use DOMElement;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

/**
 * Class GoogleSearch
 * @author Dat Pham
 */
class GoogleSearch implements SearchInterface
{
    /** @var Client */
    protected $client;

    protected $searchPage;

    protected $adwords = [];

    protected $links = [];

    protected $metadata;

    // make http client as a dependency injection for easy testing
    // I tie it to GuzzleHttp Client for now as it's the go-to Http client
    // and there is no available Http client interface that provides most of the
    // methods used here
    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function performSearch($keyword): void
    {
        $client = $this->client;
        $userAgents = $this->config['user_agents'] ?? [];
        $proxyUrls = $this->config['proxy_urls'] ?? null;

        // rotate user-agent
        $userAgent = $userAgents[array_rand($userAgents, 1)] ?? null;

        // rotate proxy server
        $proxyUrl = $proxyUrls[array_rand($proxyUrls, 1)] ?? null;

        // populate request headers
        $headers = [];
        if ($userAgent) {
            $headers['user-agent'] = $userAgent;
        }

        // set proxy (if any) for request
        if ($proxyUrl) {
            $headers['proxy'] = $proxyUrl;
        }

        $query = http_build_query([
            'q' => $keyword,
            'hl' => 'en-US',
        ]);

        $res = $client->get('/search?' . $query, [
            'headers' => $headers
        ]);
        $html = $res->getBody()->getContents();

        $this->searchPage = $html;
        $this->processByRegex($html);
        $this->metadata = $this->getMetadata($html);
    }

    public function getResults(): string
    {
        return preg_replace("/&#?[a-z0-9]+;/i","", $this->metadata);
    }

    public function getAdwords(): array
    {
        return $this->adwords;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function getHtml(): string
    {
        return $this->searchPage;
    }

    public function getMetadata(string $html)
    {
        $regex = '/<div id="result-stats">(.+?)<\/div>/';
        if (preg_match($regex, $html, $match)) {
            return strip_tags($match[1]);
        }

        return null;
    }

    public function processByRegex(string $html)
    {
        // regular expression for links
        $regex = '/<a(.+?)href=\"(.+?)\"(.+?)>/';
        if (preg_match_all($regex, $html, $matches)) {
            $this->links = $matches[2];
        }

        // regular expression for adwords
        $regex = '/>(Ad|Ads)</';
        if (preg_match_all($regex, $html, $matches)) {
            $this->adwords = $matches[1];
        }
    }

    // deprecated as some of the returned HTML is not valid,
    // it will break the DOMDocument
    public function process(string $html)
    {
        // repair html invalid formats
        $searchPage = new DOMDocument;
        $searchPage->loadHTML($html);

        $xpath = new DOMXPath($searchPage);
        foreach ($xpath->query('//a[@href]') as $link) {
            $href = $link->getAttribute('href');

            if (Str::startsWith($href, '/url?')) {
                $this->links[] = $href;
            }

            if (Str::startsWith($href, 'http://www.google.com/aclk')) {
                $this->adwords[] = $href;
            }
        }
    }
}
