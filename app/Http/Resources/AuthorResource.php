<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'nationality' => $this->nationality,
            'age' => $this->birthdate->age, // Campo calculado
            'books_count' => $this->whenCounted('books'), // Solo si se carga la relación
            'books' => BookResource::collection($this->whenLoaded('books')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('authors.show', $this->id),
            ]
        ];
    }


    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0',
                'api_version' => 'v1',
                'copyright' => '© '.date('Y').' Biblioteca API',
            ]
        ];
    }
}
