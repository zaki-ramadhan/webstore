<?php
declare(strict_types=1);
namespace App\Data;

use App\Data\CartItemData;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Livewire\Attributes\Computed;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class CartData extends Data
{
    #[Computed]
    public float $total;
    public int $total_weight;
    public int $total_quantity;
    public string $total_formatted;

    public function __construct(
        // instead of using array or collection, use this to make sure cartData is only filled by this collection data
        #[DataCollectionOf(CartItemData::class)]
        public DataCollection $items,
    ) {
        $items = $items->toCollection();

        $this->total = $items->sum(fn(CartItemData $item) => $item->price * $item->quantity);
        $this->total_weight = $items->sum(fn(CartItemData $item) => $item->weight ?? 0);
        $this->total_quantity = $items->sum(fn(CartItemData $item) => $item->quantity);
        $this->total_formatted = Number::currency($this->total);
    }

}
