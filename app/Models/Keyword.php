<?php

namespace App\Models;

use App\Events\KeywordCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keyword extends Model
{
    use HasFactory;

    const STATE_PENDING = 'pending';

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

    /**
     * initialize model lifecycle hooks
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function (Keyword $model) {
            KeywordCreated::dispatch(new KeywordCreated($model));
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
