<?php

namespace App\Services;

use App\Models\Anime;
use Illuminate\Support\Facades\Http;

class AniListService
{
    public function getTopAnimes()
    {
        //llama a la api externa
        $response = Http::post('https://graphql.anilist.co', [
            'query' => '
                query {
                    Page(page: 1, perPage: 100) {
                        media(type: ANIME, sort: POPULARITY_DESC) {
                            id
                            title {
                                romaji
                            }
                            coverImage {
                                large
                            }
                        }
                    }
                }  
            ',
        ]);
        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'No se pudo obtener datos de la API externa'];
        }
    }
    public function getAnimesByStatus()
    {
        $status = request('status');
        $ids = Anime::where('status', $status)
            ->pluck('api_id')
            ->toArray();
        $responses = Http::post('https://graphql.anilist.co', [
            'query' => '
                query ($ids: [Int]) {
                    Page(perPage: 50) {
                        media(id_in: $ids, type: ANIME) {
                            id
                            title {
                                romaji
                                english
                            }
                            coverImage {
                                    large
                            }
                        }
                    }
                }
            ',
            'variables' => [
                'ids' => $ids
            ],
        ]);
        if ($responses->successful()) {
            $data = $responses->json();
            $datos = $data['data']['Page']['media'] ?? [];
        } else {
            $datos = [
                'error' => 'No se pudo obtener datos de la API externa'
            ];
        }
        return $datos;
    }
    public function getAnimeById($id)
    {
        $response = Http::post('https://graphql.anilist.co', [
            'query' => '
                query ($id: Int) {
                    Media(id: $id, type: ANIME) {
                        id
                        title {
                            english
                            romaji
                        }
                        coverImage {
                            large
                        }
                    }
                }
            ',
            'variables' => [
                'id' => $id
            ],
        ]);
        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'No se pudo obtener datos de la API externa'];
        }
    }
}
