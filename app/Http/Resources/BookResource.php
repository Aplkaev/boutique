<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description ?? null,
            'cover' => $this->cover ?? null,
            'author' => $this->author->name,
            'publish_year' => $this->publish_year,
        ];
    }
}
