<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->price_formatted = Number::currency($product->price, 'IDR', 'id', 0);

        $product->cover_url = $product->getFirstMediaUrl('cover');
        
        return view('product.show', compact('product'));
    }
}
