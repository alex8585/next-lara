<?php

namespace App\Models;

use App\Casts\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/* use Spatie\Tags\HasTags; */

class Post extends Model
{
  use HasFactory;
  use Prunable;
  protected $guarded = ['tags', 'category'];
  /* use HasTags; */
  protected $sortFields = ['id', 'title'];

  protected $casts = [
    'created_at' => Timestamp::class,
    'updated_at' => Timestamp::class . ':Y-m-d h:i:s',
  ];

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

  public static function queryFilter()
  {
    return QueryBuilder::for(self::class)->allowedFilters([
      AllowedFilter::exact('id'),
      AllowedFilter::partial('title'),
    ]);
  }

  public function prunable()
  {
    return static::where('created_at', '<=', now()->subDays(3));
  }
}
