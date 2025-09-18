<?php

namespace App\Actions;

use App\Models\Product;
use App\Contract\CartServiceInterface;
use App\Data\ProductData;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class ValidateCartStock
{
    use AsAction;

    public function __construct(public CartServiceInterface $cart) {}

    public function handle()
    {
        // Create an array to store items that don't have enough stock
        $insufficient = [];

        // Loop through every item in the shopping cart
        foreach ($this->cart->all()->items as $item) {
            // Find the product in the database by its SKU (unique product code)
            // ⚠️ Important: use ->first() to actually get the product model, 
            // otherwise $product is just a query, not the product itself.
            /** @var ProductData $product */
            $product = Product::where('sku', $item->sku)->first();

            // Check if the product doesn't exist OR if the stock is less than the requested quantity
            if (!$product || $product->stock < $item->quantity) {
                // Add details about the insufficient item to the list
                $insufficient[] = [
                    'sku'       => $item->sku,
                    'name'      => $product->name ?? 'Unknown',
                    'requested' => $item->quantity,
                    'available' => $product?->stock ?? 0
                ];
            }
        }

        // If there are any items with insufficient stock
        if ($insufficient) {
            // Throw a ValidationException so Laravel will handle it as a validation error
            throw ValidationException::withMessages([
                'cart' => 'Oops! A few products don’t have enough stock',
                'details' => $insufficient
            ]);
        }
    }
}
