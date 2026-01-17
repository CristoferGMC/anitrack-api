<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use App\Http\Resources\AnimeResource;
use App\Models\Anime;
use App\Services\AniListService;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function __construct(
        private AniListService $aniListService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function top()
    {
        $animes = $this->aniListService->getTopAnimes();
        $media = $animes['data']['Page']['media'] ?? [];
        return AnimeResource::collection($media);
    }
    public function index()
    {
        $animes = $this->aniListService->getAnimesByStatus();
        return AnimeResource::collection($animes);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimeRequest $request)
    {
        try {
            Anime::create($request->validated());
            return response()->json([
                'message' => 'Registro exitoso'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anime = $this->aniListService->getAnimeById($id);
        return AnimeResource::make($anime['data']['Media'] ?? null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimeRequest $request, Anime $anime)
    {
        $data = $request->validated();
        $anime->update($data);
        return AnimeResource::make($anime);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anime $anime)
    {
        $anime->delete();
        return response()->noContent();
    }
}
