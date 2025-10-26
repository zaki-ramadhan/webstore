<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Product;
use App\Data\ProductData;
use Illuminate\Support\Number;
use Spatie\LaravelData\Data;
use Livewire\Attributes\Computed;

class CartItemData extends Data
{
    public function __construct(
        public string $sku,
        public int $quantity,
        public float $price,
        public int $weight,
    ) {}

    #[Computed()]
    public function calculatedTotalFormatted() {
        return Number::currency($this->price * $this->quantity, 'IDR', 'id', 0);
    }

    #[Computed()]
    public function product(){
        return ProductData::fromModel(
            Product::where('sku', $this->sku)->first()
        );
    }
}
