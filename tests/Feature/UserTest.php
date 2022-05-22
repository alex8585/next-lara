<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);
beforeEach(fn() => $this->seed(UserSeeder::class));

test('users index', function () {
  $response = get('/api/v1/users');

  $response->assertStatus(200);
  /* $response->dump(); */

  $response->assertJson(
    fn(AssertableJson $json) => $json
      ->hasAll('data', 'links', 'meta')
      ->etc()
      ->has('data', 1)
      ->has(
        'data.0',
        fn($json) => $json
          ->hasAll(
            'email',
            'name',
            'email_verified_at',
            'created_at',
            'updated_at'
          )
          ->whereAllType([
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
          ])
      )
  );
  $response->assertStatus(200);
});
