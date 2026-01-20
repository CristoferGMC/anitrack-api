<?php

namespace App\Services;

use App\Models\Anime;
use Illuminate\Support\Facades\Http;

class AniListService
{
    public function getTopAnimes()
    {
        //llama a la api externa para mostrar los 100 animes mas populares
        $response = Http::post('https://graphql.anilist.co', [
            'query' => '
                query {
                    Page(page: 1, perPage: 100) {
                        media(type: ANIME, sort: POPULARITY_DESC) {
                            id
                            title {
                                romaji
                            }
                            type
                            format
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
    public function getAnimeById($id)
    {
        try {
            $response = Http::post('https://graphql.anilist.co', [
                'query' => '
                    query ($id: Int) {
                        Media(id: $id, type: ANIME) {
                            id
                            title {
                                english
                                romaji
                            }
                            type
                            description
                            format
                            status
                            season
                            episodes
                            genres
                            studios {
                                nodes {
                                    name
                                }
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
            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el anime de la API externa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAnimeArrayIds(array $ids)
    {
        try {
            $responses = Http::post('https://graphql.anilist.co', [
                'query' => '
                query ($ids: [Int]) {
                    Page(perPage: 25) {
                        media(id_in: $ids, type: ANIME) {
                            id
                            title {
                                romaji
                                english
                            }
                            type
                            format
                            coverImage {
                                    large
                            }
                        }
                    }
                }
            ',
                'variables' => [
                    'ids' => $ids,
                ],
            ]);
            $data = $responses->json();
            $datos = $data['data']['Page']['media'] ?? [];
            return $datos;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los animes de la API externa',
                //'error' => $e->getMessage() // quitar en produccion
            ], 500);
        }
    }
    public function getAnimesByStatus()
    {
        $status = request('status');
        $user = auth()->user();
        $ids = $user->animes()
            ->where('status', $status)
            ->pluck('api_id')
            ->toArray();
        if (empty($ids)) {
            return [];
        }
        $animes = $this->getAnimeArrayIds($ids);
        return $animes;
    }
    public function getAnimeByTitle($id)
    {
        try {
            $response = Http::post('https://graphql.anilist.co', [
                'query' => '
                    query ($id: Int) {
                        Media(id: $id, type: ANIME) {
                            title {
                                english
                                romaji
                            }
                            type
                        }
                    }
                ',
                'variables' => [
                    'id' => $id
                ],
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el anime de la API externa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function storeAnime(array $data)
    {
        $response = $this->getAnimeById($data['api_id']);
        $data['title'] = $response['data']['Media']['title']['romaji'] ?? null;
        $data['type'] = $response['data']['Media']['type'] ?? null;
        return $data;
    }
    public function showAnime($id)
    {
        $response = $this->getAnimeById($id);
        $anime = auth()->user()->animes()->where('api_id', $id)->first();
        if ($anime) {
            $response['data']['Media']['id_registro'] = $anime->id;
            $response['data']['Media']['status_anime'] = $anime->status;
        }
        return $response['data']['Media'] ?? null;
    }
}
