<?php

namespace Tests\Feature;

use App\Models\Category;
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

  public function test_create_category()
  {
    $response = $this->post('api/v1/categories', [
      'name' => 'cat1',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('message', 'Category created successfully!')
    );

    /* $response->dump(); */
  }

  public function test_show_category()
  {
    $this->seed(CategorySeeder::class);
    $catId = Category::first()->id;

    $response = $this->get("api/v1/categories/${catId}");

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

    $response = $this->post("api/v1/categories/${catId}", [
      'name' => 'cat2',
      '_method' => 'PUT',
    ]);

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $catId)
        ->where('message', 'Category updated successfully!')
    );

    /* $response->dump(); */
  }

  public function test_delete_category()
  {
    $this->seed(CategorySeeder::class);
    $catId = Category::first()->id;

    $response = $this->delete("api/v1/categories/${catId}");

    $response->assertStatus(200);
    $response->assertJson(
      fn(AssertableJson $json) => $json
        ->hasAll('id', 'message')
        ->where('id', $catId)
        ->where('message', 'Category deleted successfully!')
    );

    /* $response->dump(); */
  }
}
