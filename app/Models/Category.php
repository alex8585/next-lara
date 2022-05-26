<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Category extends Model
{
  use HasFactory;
  protected $sortFields = ['id', 'name'];

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public static function queryFilter()
  {
    return QueryBuilder::for(self::class)->allowedFilters([
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
    ]);
  }
}
