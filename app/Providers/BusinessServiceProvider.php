<?php

namespace App\Providers;

use App\Services\Contracts\ResourceContract;
use App\Services\Contracts\ResourceTypeContract;
use App\Services\ResourceService;
use App\Services\ResourceTypeService;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ResourceTypeContract::class, ResourceTypeService::class);
        $this->app->singleton(ResourceContract::class, ResourceService::class);
    }
}
