<?php

namespace App\Services;

use App\Models\Anime;
use App\Models\Manga;
use Illuminate\Support\Facades\Http;

class MangaListService
{
    public function getTopMangas()
    {
        //llama a la api externa
        $response = Http::post('https://graphql.anilist.co', [
            'query' => '
                query {
                    Page(page: 1, perPage: 100) {
                        media(type: MANGA, sort: POPULARITY_DESC) {
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
    public function getMangaById($id)
    {
        try {
            $response = Http::post('https://graphql.anilist.co', [
                'query' => '
                    query ($id: Int) {
                        Media(id: $id, type: MANGA) {
                            id
                            title {
                                english
                                romaji
                            }
                            type
                            description
                            format
                            status
                            genres
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
                'message' => 'Error al obtener el manga de la API externa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getMangaArrayIds(array $ids)
    {
        try {
            $responses = Http::post('https://graphql.anilist.co', [
                'query' => '
                query ($ids: [Int]) {
                    Page(perPage: 25) {
                        media(id_in: $ids, type: MANGA) {
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
                'message' => 'Error al obtener los mangas de la API externa',
                //'error' => $e->getMessage() // quitar en produccion
            ], 500);
        }
    }
    public function getMangasByStatus()
    {
        $status = request('status');
        $user = auth()->user();
        $ids = $user->mangas()
            ->where('status', $status)
            ->pluck('api_id')
            ->toArray();
        if (empty($ids)) {
            return [];
        }
        $mangas = $this->getMangaArrayIds($ids);
        return $mangas;
    }
    public function getMangaByTitle($id)
    {
        try {
            $response = Http::post('https://graphql.anilist.co', [
                'query' => '
                    query ($id: Int) {
                        Media(id: $id, type: MANGA) {
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
                'message' => 'Error al obtener el manga de la API externa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function storeManga(array $data)
    {
        $response = $this->getMangaById($data['api_id']);
        $data['title'] = $response['data']['Media']['title']['romaji'] ?? null;
        $data['type'] = $response['data']['Media']['type'] ?? null;
        return $data;
    }
    public function showManga($id)
    {
        $response = $this->getMangaById($id);
        $manga = auth()->user()->mangas()->where('api_id', $id)->first();
        if ($manga) {
            $response['data']['Media']['id_registro'] = $manga->id;
            $response['data']['Media']['status_manga'] = $manga->status;
        }
        return $response['data']['Media'] ?? null;
    }
}
