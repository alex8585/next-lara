<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\TimeConverter;
use App\Support\TransHelp;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TimeConverter::class, function ($app) {
            return new TimeConverter();
        });
        $this->app->bind(TransHelp::class, function ($app) {
            return new TransHelp();
        });

    //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    //
    }
}
