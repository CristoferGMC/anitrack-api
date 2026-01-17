<?php

namespace App\Models;

use App\Enums\AnimeStatus;

class Manga extends Api
{
    protected $fillable = [
        'title',
        'type',
        'volumes',
        'chapters',
        'status',
        'api_id',
        'user_id',
    ];
    protected $casts = [
        'volumes' => 'integer',
        'chapters' => 'integer',
        'api_id' => 'integer',
        'status' => AnimeStatus::class,
    ];
}
