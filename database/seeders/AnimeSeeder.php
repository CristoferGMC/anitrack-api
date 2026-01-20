<?php

namespace Database\Seeders;

use App\Models\Anime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animes = [
            [
                'title' => 'Shingeki no Kyojin',
                'type' => 'anime',
                'status' => 'siguiendo',
                'episodes' => null,
                'api_id' => 16498,
                'user_id' => 1,
            ],
            [
                'title' => 'Kimetsu no Yaiba',
                'type' => 'anime',
                'status' => 'siguiendo',
                'episodes' => 2,
                'api_id' => 101922,
                'user_id' => 1,
            ],
            [
                'title' => 'Death Note',
                'type' => 'anime',
                'status' => 'siguiendo',
                'episodes' => 1,
                'api_id' => 1535,
                'user_id' => 1,
            ],
            [
                'title' => 'HUNTER×HUNTER (2011)',
                'type' => 'anime',
                'status' => 'siguiendo',
                'episodes' => 2,
                'api_id' => 11061,
                'user_id' => 1,
            ],
            [
                'title' => 'One Punch Man',
                'type' => 'anime',
                'status' => 'favorito',
                'episodes' => 3,
                'api_id' => 21087,
                'user_id' => 1,
            ],
        ];
        Anime::insert($animes);
    }
}
