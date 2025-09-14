<?php

namespace App\Providers;

use App\Contract\CartServiceInterface;
use App\Models\Product;
use App\Services\SessionCartService;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // add this to make load method works
        // add new binding to enable anywhere the app needs cart service interface then resolve it by giving concrete class
        $this->app->bind(CartServiceInterface::class, SessionCartService::class);
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
