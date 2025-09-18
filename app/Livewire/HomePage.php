<?php

namespace App\Livewire;

use App\Data\ProductData;
use Livewire\Component;
use App\Models\Product;

class HomePage extends Component
{
    public function render()
    {
        $feature_products = ProductData::collect(
            Product::query()->inRandomOrder()->limit(3)->get()
        );

        $latest_products = ProductData::collect(
            Product::query()->latest()->limit(3)->get()
        );

        return view('livewire.home-page', compact('feature_products', 'latest_products'));
    }
}
