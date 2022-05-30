<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    /* Post::class => PostPolicy::class, */
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot()
  {
    $this->registerPolicies();

    ResetPassword::createUrlUsing(function ($notifiable, $token) {
      return config('app.frontend_url') .
        "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}";
    });

    //
  }
}
