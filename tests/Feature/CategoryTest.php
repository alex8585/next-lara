<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategorySeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class CategoryTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_categories_index_has_categories()
  {
    $this->seed(CategorySeeder::class);
    $response = $this->get('/api/v1/categories');

    $response->assertStatus(200);
    /* $response->dump(); */

    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('data', 'links', 'meta')
        ->etc()
        ->has('data', 5)
        ->has(
          'data.0',
          fn($json) => $json->hasAll('id', 'name')->whereAllType([
            'id' => 'integer',
            'name' => 'string',
          ])
        )
    );
  }
}
