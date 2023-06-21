<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Models\Brand;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BrandRepository::class, function ($app) {
            return new BrandRepository(new Brand());
        });

        $this->app->bind(BrandService::class, function ($app) {
            return new BrandService($app->make(BrandRepository::class));
        });

        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository(new Product());
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
