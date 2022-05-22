<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
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

  public function test_create_post()
  {
    $response = $this->post('api/v1/posts', [
      'title' => 'post-title',
      'description' => 'post-description',
      'user_id' => 1,
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('message', 'Post created successfully!')
    );

    $this->assertDatabaseCount('posts', 1);
    /* $response->dump(); */
  }

  public function test_show_post()
  {
    $this->seed(postSeeder::class);
    $postId = post::first()->id;

    $response = $this->get("api/v1/posts/${postId}");

    /* $response->dump(); */
    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll(
          'id',
          'title',
          'user_id',
          'description',
          'created_at_str',
          'updated_at_str',
          'created_at',
          'updated_at',
          'tags',
          'category'
        )
        ->where('id', $postId)
    );
  }

  public function test_update_post()
  {
    $this->seed(postSeeder::class);
    $postId = post::first()->id;

    $postTitle = 'test-post-title';
    $response = $this->post("api/v1/posts/${postId}", [
      'title' => $postTitle,
      'description' => 'post-description',
      'user_id' => 1,
      '_method' => 'PUT',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $postId)
        ->where('message', 'Post updated successfully!')
    );

    $this->assertDatabaseHas('posts', [
      'title' => $postTitle,
    ]);
    /* $response->dump(); */
  }

  public function test_delete_post()
  {
    $this->seed(postSeeder::class);
    $post = post::first();

    $response = $this->delete("api/v1/posts/{$post->id}");

    /* $response->dump(); */
    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $post->id)
        ->where('message', 'Post deleted successfully!')
    );
    $this->assertDatabaseCount('posts', 4);
    $this->assertModelMissing($post);
  }
}
