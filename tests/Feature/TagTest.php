<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TagTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   */
  public function test_tags_index_has_tags()
  {
    $this->seed(TagSeeder::class);
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/api/v1/tags');

    $response->assertStatus(200);
    /* $response->dump(); */

    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('data', 'metaData')
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
    $user = User::factory()->create();
    $response = $this->actingAs($user)->post('api/v1/tags', [
      'name' => 'tag1',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('message', 'Tag created successfully!')
    );

    $this->assertDatabaseCount('tags', 1);
    /* $response->dump(); */
  }

  public function test_show_tag()
  {
    $this->seed(TagSeeder::class);
    $tagId = Tag::first()->id;

    $user = User::factory()->create();
    $response = $this->actingAs($user)->get("api/v1/tags/{$tagId}");

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

    $tagName = 'test-tag-name';
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post("api/v1/tags/{$tagId}", [
      'name' => $tagName,
      '_method' => 'PUT',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $tagId)
        ->where('message', 'Tag updated successfully!')
    );
    $this->assertDatabaseHas('tags', [
      'name' => $tagName,
    ]);
    /* $response->dump(); */
  }

  public function test_delete_tag()
  {
    $this->seed(TagSeeder::class);
    $tag = Tag::first();

    $user = User::factory()->create();
    $response = $this->actingAs($user)->delete("api/v1/tags/{$tag->id}");

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $tag->id)
        ->where('message', 'Tag deleted successfully!')
    );
    $this->assertDatabaseCount('tags', 4);
    $this->assertModelMissing($tag);
    /* $response->dump(); */
  }
}
