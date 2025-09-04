<?php
declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\Tags\Tag;

class ProductCollectionData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public int $product_count
    ) {}

    public static function fromModel(Tag $tag): self
    {
        return new self(
            $tag->id,
            (String) $tag->name,
            (String) $tag->slug,
            $tag->products_count
        );
    }
}
