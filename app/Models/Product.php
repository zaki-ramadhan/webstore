<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTags;

    // conversion to generate "cover"
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('cover') // define a media conversion named "cover"
            ->fit(Fit::Contain, 300, 300) // resize image to fit within 300x300 without cropping
            ->nonQueued(); // process immediately (not queued)
    }
}
