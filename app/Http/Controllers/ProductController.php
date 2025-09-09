<?php

namespace App\Http\Controllers;

use App\Data\ProductData;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // override using DTO
        $product = ProductData::fromModel($product, true);
        
        return view('product.show', compact('product'));
    }
}
