<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->routeIs('authors.show')) {
            return [
                'slug' => $this->slug,
                'name' => $this->name,
                'description' => $this->description ?? null,
                'books_count' => $this->books()->count(),
                'books' => BookResource::collection($this->books),
            ];
        } else {
            return [
                'slug' => $this->slug,
                'name' => $this->name,
                'description' => $this->description ?? null,
                'books_count' => $this->books()->count(),
            ];
        }
    }
}
