<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Book extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;

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
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('cover') ?? null,
            set: function($value) {
                $this->clearMediaCollection('cover');
                $this->addMediaFromRequest($value)->toMediaCollection('cover');
            },
        );
    }

    /* cover image thumb */
    public function coverThumb(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('cover', 'thumb') ?? null
        );
    }

    /* configure media collection */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->useDisk('public')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_FILL, 300, 500);
            });
    }

    /* get slug options */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /* get route keyname */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}
