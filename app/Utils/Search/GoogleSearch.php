<?php

namespace App\Utils\Search;

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
    protected $searchPage;

    protected $adwords = [];

    protected $links = [];

    protected $metadata;

    public function __construct($keyword)
    {
        $client = new Client([
            'base_uri' => 'https://www.google.com',
        ]);

        $query = http_build_query([
            'q' => $keyword,
            'hl' => 'en-US',
        ]);

        // search query to get raw HTML
        $res = $client->get('/search?' . $query, [
            'headers' => [
                // using old user-agent to get non-javascript, html only search results
                'user-agent' => 'Mozilla/5.0 (MSIE 9.0; Windows NT 6.1; Trident/5.0)',
            ]
        ]);
        $html = $res->getBody()->getContents();
        // $html = file_get_contents(base_path('/data/search.html'));

        $this->process($html);
        $this->searchPage = $html;

        // search query to get total results
        $res = $client->get('/search?' . $query, [
            'headers' => [
                // using chrome user-agent to get search metadata
                'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
            ]
        ]);
        $html = $res->getBody()->getContents();
        // $html = file_get_contents(base_path('/data/search-js.html'));

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

    public function process(string $html)
    {
        // repair html invalid formats
        $html = str_replace('</table></a>', '</table>', $html);

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
