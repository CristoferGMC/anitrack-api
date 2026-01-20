<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMangaRequest;
use App\Http\Requests\UpdateMangaRequest;
use App\Http\Resources\MangaResource;
use App\Http\Resources\MangaShowResource;
use App\Http\Resources\MangaStoreResource;
use App\Models\Manga;
use App\Services\MangaListService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MangaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index', 'top', 'show']),
        ];
    }

    public function __construct(
        private MangaListService $mangaListService
    ) {}

    public function top()
    {
        $mangas = $this->mangaListService->getTopMangas();
        $media = $mangas['data']['Page']['media'] ?? [];
        return MangaResource::collection($media);
    }

    public function index()
    {
        $mangas = $this->mangaListService->getMangasByStatus();
        return  MangaResource::collection($mangas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMangaRequest $request)
    {
        $data = $request->validated();
        $response = $this->mangaListService->storeManga($data);
        $manga = $request->user()->mangas()->create($response);
        return MangaStoreResource::make($manga, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $manga = $this->mangaListService->showManga($id);
        return MangaShowResource::make($manga);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMangaRequest $request, Manga $manga)
    {
        $data = $request->validated();
        $manga->update($data);
        return response()->json([
            'message' => 'Actualización exitosa'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        $manga->delete();
        return response()->noContent();
    }
}
