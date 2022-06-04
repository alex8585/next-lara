<?php

namespace App\Models;

use App\Casts\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Laravel\Scout\Searchable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/* use Spatie\Tags\HasTags; */

class Post extends Model
{
  use Searchable;
  use HasFactory;
  use Prunable;
  protected $guarded = ['tags', 'category'];
  /* use HasTags; */
  protected $sortFields = ['id', 'title'];

  protected $casts = [
    'created_at' => Timestamp::class,
    'updated_at' => Timestamp::class . ':Y-m-d h:i:s',
  ];

  // public function searchableAs()
  // {
  //   return 'posts_index';
  // }
  //
  //
  public function toSearchableArray(): array
  {
    return [
      'description' => $this->description,
      'title' => $this->title,
    ];
  }

  public function category()
  {
    return $this->belongsTo(Category::class)->withDefault([
      'name' => 'Default',
    ]);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class)->withTimestamps();
  }

  public static function queryFilter($query = self::class)
  {
    $filter = request()->query('filter', null);

    $tagsIds = isset($filter['tags']) ? explode(',', $filter['tags']) : null;

    return QueryBuilder::for($query)->allowedFilters([
      AllowedFilter::exact('id'),
      AllowedFilter::exact('category', 'category_id'),
      AllowedFilter::partial('title'),
      AllowedFilter::partial('description'),
      AllowedFilter::callback(
        'tags',
        fn($query) => $query->whereHas('tags', function ($query) use (
          $tagsIds
        ) {
          $query->whereIn('tags.id', $tagsIds);
        })
      ),
    ]);
  }

  public function prunable()
  {
    return static::where('created_at', '<=', now()->subDays(3));
  }
}
