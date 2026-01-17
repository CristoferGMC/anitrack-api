<?php

namespace App\Http\Controllers;

use App\Http\Resources\MangaResource;
use App\Models\Manga;
use App\Services\MangaListService;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function __construct(
        private MangaListService $mangaListService
    ) {}

    public function top()
    {
        $mangas = $this->mangaListService->getTopMMangas();
        $media = $mangas['data']['Page']['media'] ?? [];
        return MangaResource::collection($media);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Manga $manga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        //
    }
}
