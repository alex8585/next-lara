<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\TagSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Tag;

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

  public function test_create_tag()
  {
    $response = $this->post('api/v1/tags', [
      'name' => 'tag1',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('message', 'Tag created successfully!')
    );

    /* $response->dump(); */
  }

  public function test_show_tag()
  {
    $this->seed(TagSeeder::class);
    $tagId = Tag::first()->id;

    $response = $this->get("api/v1/tags/${tagId}");

    /* $response->dump(); */
    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'name')
        ->where('id', $tagId)
    );
  }

  public function test_update_tag()
  {
    $this->seed(TagSeeder::class);
    $tagId = Tag::first()->id;

    $response = $this->post("api/v1/tags/${tagId}", [
      'name' => 'tag2',
      '_method' => 'PUT',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $tagId)
        ->where('message', 'Tag updated successfully!')
    );

    /* $response->dump(); */
  }

  public function test_delete_tag()
  {
    $this->seed(TagSeeder::class);
    $tagId = Tag::first()->id;

    $response = $this->delete("api/v1/tags/${tagId}");

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $tagId)
        ->where('message', 'Tag deleted successfully!')
    );

    /* $response->dump(); */
  }
}
