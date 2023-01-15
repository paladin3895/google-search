<?php

namespace App\Jobs;

use App\Models\Keyword;
use App\Utils\SearchEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class KeywordSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Keyword $keyword)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Keyword */
        $keyword = $this->keyword;
        if (!$keyword) {
            throw new InvalidArgumentException('Keyword was missing');
        }

        $keyword->update([
            'state' => Keyword::STATE_PROCESSING,
        ]);

        $searchEngine = new SearchEngine;
        /** @var GoogleSearch */
        $searchResult = $searchEngine->search('Google', $keyword->key);

        $keyword->update([
            'state' => Keyword::STATE_PROCESSED,
            'adwords' => count($searchResult->getAdwords()),
            'links' => count($searchResult->getLinks()),
            'results' => $searchResult->getResults(),
            'html' => $searchResult->getHtml(),
        ]);

    }
}
