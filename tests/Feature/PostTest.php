<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Testing\Fluent\AssertableJson;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\PostSeeder;
class PostTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_posts_index_has_posts()
  {
    $this->seed(PostSeeder::class);
    $response = $this->get('/api/v1/posts');

    /* $response->dump(); */
    $response->assertStatus(200);

    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('data', 'links', 'meta')
        ->etc()
        ->has('data', 5)
        ->has(
          'data.0',
          fn($json) => $json
            ->hasAll(
              'id',
              'user_id',
              'title',
              'description',
              'tags',
              'category'
            )
            ->etc()
        )
        ->whereAllType([
          'data.0.tags' => 'array',
          'data.0.category' => 'array',
        ])
    );
  }
}
