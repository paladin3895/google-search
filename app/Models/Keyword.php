<?php

namespace App\Models;

use App\Jobs\KeywordSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class Keyword extends Model
{
    use HasFactory;

    const STATE_PROCESSING = 'processing';

    const STATE_PROCESSED = 'processed';

    public $fillable = [
        'user_id',
        'key',
        'file_name',
        'adwords',
        'links',
        'results',
        'responsed_time',
        'html',
        'stats',
        'state',
    ];

    public $casts = [
        'stats' => 'array',
    ];

    public $hidden = [
        'html',
    ];

    /**
     * initialize model lifecycle hooks
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // observers that should not be applied when model is used in cli
        if (App::runningInConsole()) {
            return;
        }

        static::created(function (Keyword $model) {
            KeywordSearch::dispatch($model);
        });
    }

    /**
     * get owner
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
