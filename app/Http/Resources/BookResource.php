<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'isbn' => $this->isbn,
            'published_date' => $this->published_date->format('Y-m-d'),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'author_id' => $this->author_id,
            'years_since_publication' => now()->diffInYears($this->published_date),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                'self' => route('books.show', $this->id),
                'author' => route('authors.show', $this->author_id),
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
