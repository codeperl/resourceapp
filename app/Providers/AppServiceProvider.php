<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use bootstrap pagination
        Paginator::useBootstrap();
        /**
         * The way innodb MySQL databases worked was that you can only have 767 bytes for an index - enough to store 255
         * 3-byte characters (767/3 = 255). This is an extreme example of index optimization based on knowing the size
         * of the data you are indexing! So if the characters took more space to store, then the number of characters
         * you could index had to get smaller. Specifically, 767/4 = 191 characters!
         */
        Schema::defaultStringLength(191);
    }
}
