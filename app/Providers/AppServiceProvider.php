<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Number;
use App\Actions\ValidateCartStock;
use App\Services\SessionCartService;
use Illuminate\Support\Facades\Gate;
use App\Contract\CartServiceInterface;
use App\Services\RegionQueryService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

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

        $this->app->bind(RegionQueryService::class, RegionQueryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // allow mass assignment for product model
        Product::unguard();
        Number::useCurrency('IDR');

        // to prevent bypass injection ('.../checkout') through URL when stock is less than quantity request by user
        // 'Gate' is like policy in laravel but simpler
        Gate::define('is_stock_available', function(User $user = null) {
            try {
                ValidateCartStock::run();
                return true; // ensure return must be boolean value
            } catch (ValidationException $err) {
                session()->flash('error', $err->getMessage());
                return false; // ensure return must be boolean value
            }
        });
    }
}
