<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  public function test_api_can_authenticate_using_jwt()
  {
    $user = User::factory()->create();

    config(['auth.defaults.guard' => 'api']);
    $response = $this->post('api/v1/auth/login', [
      'email' => $user->email,
      'password' => 'password',
    ]);
    $response->assertStatus(200);
    /* $response->dump(); */

    /* $response->dumpHeaders(); */
    /* $response->dumpSession(); */
    $response->assertJson(
      fn(AssertableJson $json) => $json->hasAll(
        'access_token',
        'token_type',
        'expires_in'
      )
    );
    $this->assertAuthenticated('api');

    /* $response->assertNoContent(); */
  }

  public function test_api_can_not_authenticate_with_invalid_password()
  {
    $user = User::factory()->create();

    config(['auth.defaults.guard' => 'api']);
    $response = $this->post('api/v1/auth/login', [
      'email' => $user->email,
      'password' => 'wrong-password',
    ]);

    /* $response->dump(); */
    $response->assertStatus(401)->assertJson([
      'error' => 'Unauthorized',
    ]);

    $this->assertGuest();
  }

  public function test_users_can_authenticate_using_the_login_screen()
  {
    $user = User::factory()->create();

    config(['auth.defaults.guard' => 'web']);
    $response = $this->post('/login', [
      'email' => $user->email,
      'password' => 'password',
    ]);
    /* $response->dump(); */
    /* $response->dumpHeaders(); */
    /* $response->dumpSession(); */

    $this->assertAuthenticated('web');
    $response->assertNoContent();
  }

  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $user = User::factory()->create();

    $this->post('/login', [
      'email' => $user->email,
      'password' => 'wrong-password',
    ]);

    $this->assertGuest();
  }
}
