<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MangaShowResource extends JsonResource
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
            'estado'      => $this->resource['status_manga'] ?? null,
            'id'     => $this['id'],
            'nombre' => $this['title']['romaji'] ?? null,
            'tipo'   => $this['type'] ?? null,
            'descripcion' => $this['description'] ?? null,
            'formato'   => $this['format'] ?? null,
            'generos' => $this['genres'] ?? null,
            'estado_manga' => $this['status'] ?? null,
            'imagen' => $this['coverImage']['large'] ?? null,
        ];
    }
}
