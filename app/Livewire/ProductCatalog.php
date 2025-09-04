<?php

namespace App\Livewire;

use App\Data\ProductData;
use App\Models\Product;
use Livewire\Component;

class ProductCatalog extends Component
{
    public function render()
    {
        // Fetches a full collection of `Product` models with all their attributes.
        // This is "heavy" because it loads more data than is needed for the view,
        // which can impact performance on a large database.
        $query = Product::paginate(9);

        // The reasons for using a "DTO" for this project
        // 1. Clean code: It separates the data from the business logic.
        // 2. Built-in Validation & Typing (using Spatie)
        // 3. Flexible and easy to maintain
        // 4. Reduces payload by sending only relevant properties. 

        $products = ProductData::collect($query);

        return view('livewire.product-catalog', compact('products'));
    }
}
