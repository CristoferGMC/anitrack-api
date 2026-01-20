<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_registro' => $this->resource['id_registro'] ?? null,
            'estado'      => $this->resource['status_anime'] ?? null,
            'id'     => $this['id'],
            'nombre' => $this['title']['romaji'] ?? null,
            'tipo'   => $this['type'] ?? null,
            'descripcion' => $this['description'] ?? null,
            'formato'   => $this['format'] ?? null,
            'episodios' => $this['episodes'] ?? null,
            'generos' => $this['genres'] ?? null,
            'estudio' => $this['studios']['nodes'][0]['name'] ?? null,
            'temporada' => $this['season'] ?? null,
            'estado_anime' => $this['status'] ?? null,
            'imagen' => $this['coverImage']['large'] ?? null,

        ];
    }
}
