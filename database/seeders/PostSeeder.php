<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $cats = Category::factory()
      ->count(5)
      ->create();

    Post::factory()
      ->count(5)
      /* ->for($cats->random(1)->first()) */
      ->hasAttached(Tag::factory()->count(3), [
        'created_at' => now(),
        'updated_at' => now(),
      ])
      ->create();

    Post::select(['id'])->each(function ($post) use ($cats) {
      $post->category_id = $cats->random(1)->first()->id;
      $post->save();
    });
  }
}
