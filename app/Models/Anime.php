<?php

namespace App\Models;

use App\Enums\AnimeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anime extends Api
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'episodes',
        'status',
        'api_id',
    ];
    protected $casts = [
        'episodes' => 'integer',
        'api_id' => 'integer',
        'status' => AnimeStatus::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
