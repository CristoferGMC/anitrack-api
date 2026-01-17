<?php

namespace App\Models;

use App\Enums\AnimeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anime extends Api
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'episodes',
        'status',
        'api_id',
        'user_id',
    ];
    protected $casts = [
        'episodes' => 'integer',
        'api_id' => 'integer',
        'status' => AnimeStatus::class,
    ];
}
