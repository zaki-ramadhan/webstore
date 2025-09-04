<?php

declare(strict_types=1); // Enables strict typing to prevent data type errors.

namespace App\Data;

use App\Models\Product;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Computed;

class ProductData extends Data
{
    #[Computed]
    public string $price_formatted; // Indicates that this property will be computed dynamically, not from a database column.

    public function __construct(
        public string $name,
        public string $sku,
        public string $slug,
        public string|Optional|null $description,
        public int $stock,
        public float $price,
        public int $weight,
    ) {
        // Formats the product's price as a currency string.
        $this->price_formatted = Number::currency($price, 'IDR', 'id', 0);
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            $product->name,
            $product->sku,
            $product->slug,
            $product->description,
            $product->stock,
            floatval($product->price),
            $product->weight,
        );
    }
}
