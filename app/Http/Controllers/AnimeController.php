<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use App\Http\Resources\AnimeResource;
use App\Http\Resources\AnimeShowResource;
use App\Http\Resources\AnimeStoreResource;
use App\Models\Anime;
use App\Services\AniListService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AnimeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'top', 'show']),
        ];
    }
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
    /*
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimeRequest $request)
    {
        $data = $request->validated();
        $response = $this->aniListService->storeAnime($data);
        $anime = $request->user()->animes()->create($response);
        return AnimeStoreResource::make($anime, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anime = $this->aniListService->showAnime($id);
        return AnimeShowResource::make($anime);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimeRequest $request, Anime $anime)
    {
        $data = $request->validated();
        $anime->update($data);
        return response()->json([
            'message' => 'Actualización exitosa'
        ], 200);
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
