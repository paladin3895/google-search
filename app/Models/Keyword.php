<?php

namespace App\Models;

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
     * get owner
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
