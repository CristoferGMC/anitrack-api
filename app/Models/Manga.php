<?php

namespace App\Models;

use App\Enums\AnimeStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manga extends Api
{
    protected $fillable = [
        'title',
        'type',
        'volumes',
        'chapters',
        'status',
        'api_id',
    ];
    protected $casts = [
        'volumes' => 'integer',
        'chapters' => 'integer',
        'api_id' => 'integer',
        'status' => AnimeStatus::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
