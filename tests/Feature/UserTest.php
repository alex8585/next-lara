<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);
beforeEach(fn () => $this->seed(UserSeeder::class));

test('users index', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/users');

    $response->assertStatus(200);
    /* $response->dump(); */

    $response->assertJson(
        fn (AssertableJson $json) => $json
          ->hasAll('data', 'metaData')
          ->etc()
          ->has('data', 2)
          ->has(
              'data.0',
              fn ($json) => $json
                ->hasAll(
                    'email',
                    'name',
                    'email_verified_at',
                    'role',
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
