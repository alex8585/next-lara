<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\TagSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class TagTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_tags_index_has_tags()
  {
    $this->seed(TagSeeder::class);
    $response = $this->get('/api/v1/tags');

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
