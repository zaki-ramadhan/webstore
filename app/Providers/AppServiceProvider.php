<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // allow mass assignment for product model
        Product::unguard();
        Number::useCurrency('IDR');
    }
}
