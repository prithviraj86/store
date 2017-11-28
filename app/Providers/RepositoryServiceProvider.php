<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind("App\Repositories\Category\CategoryInterface", "App\Repositories\Category\CategoryRepository");
        $this->app->bind("App\Repositories\Product\ProductInterface", "App\Repositories\Product\ProductRepository");
    }
}
