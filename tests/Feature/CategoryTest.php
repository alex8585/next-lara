<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoryTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   */
  public function test_categories_index_has_categories()
  {
    $this->seed([CategorySeeder::class]);

    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/api/v1/categories');

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

  public function test_create_category()
  {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->post('api/v1/categories', [
      'name' => 'cat1',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('message', 'Category created successfully!')
    );

    $this->assertDatabaseCount('categories', 1);
    /* $response->dump(); */
  }

  public function test_show_category()
  {
    $this->seed(CategorySeeder::class);
    $catId = Category::first()->id;

    $user = User::factory()->create();
    $response = $this->actingAs($user)->get("api/v1/categories/{$catId}");

    /* $response->dump(); */
    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'name')
        ->where('id', $catId)
    );
  }

  public function test_update_category()
  {
    $this->seed(CategorySeeder::class);
    $catId = Category::first()->id;

    $catName = 'test-cat-name';
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post("api/v1/categories/{$catId}", [
      'name' => $catName,
      '_method' => 'PUT',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $catId)
        ->where('message', 'Category updated successfully!')
    );

    $this->assertDatabaseHas('categories', [
      'name' => $catName,
    ]);
    /* $response->dump(); */
  }

  public function test_delete_category()
  {
    $this->seed(CategorySeeder::class);
    $cat = Category::first();

    $user = User::factory()->create();
    $response = $this->actingAs($user)->delete("api/v1/categories/{$cat->id}");

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $cat->id)
        ->where('message', 'Category deleted successfully!')
    );

    $this->assertDatabaseCount('categories', 4);
    $this->assertModelMissing($cat);
    /* $response->dump(); */
  }
}
