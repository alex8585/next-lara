<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Support\TimeConverter;
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
