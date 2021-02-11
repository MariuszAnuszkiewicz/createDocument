<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ParseXlsx;
use SimpleXLSX;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ParseXlsx::class, function ($app) {
            return new ParseXlsx($app->make(SimpleXLSX::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
