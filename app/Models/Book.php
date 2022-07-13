<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Book extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'author_id',
        'publish_year',
    ];

    /* belongs to author */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /* cover image attribute */
    public function cover(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getFirstMediaUrl('cover', 'thumb') ?? null,
            set: fn($value) => $this->addMedia($value)->toMediaCollection('cover'),
        );
    }

    /* configure media collection */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsFile('image/*')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }

}
