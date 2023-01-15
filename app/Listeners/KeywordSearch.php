<?php

namespace App\Listeners;

use App\Events\KeywordCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KeywordSearch
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  KeywordCreated  $event
     * @return void
     */
    public function handle(KeywordCreated $event)
    {
        //
    }
}
