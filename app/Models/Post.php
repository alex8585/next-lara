<?php

namespace App\Models;

use App\Casts\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Support\Facades\DB;
use Astrotomic\Translatable\Translatable;
/* use Spatie\Tags\HasTags; */

class Post extends Model
{
  use Searchable;
  use HasFactory;
  use Prunable;
  use Translatable;

  public $translatedAttributes = ['title','description'];

  protected $guarded = ['tags', 'category'];
  /* use HasTags; */
  protected $sortFields = ['id', 'title','description'];

  protected $casts = [
    'created_at' => Timestamp::class,
    'updated_at' => Timestamp::class . ':Y-m-d h:i:s',
  ];

  // #[SearchUsingPrefix(['title', 'description'])]
  //  #[SearchUsingFullText(['title', 'description'])]
  public function toSearchableArray(): array
  {
    return [
      'description' => $this->description,
      'title' => $this->title,
      'category' => $this->category->name,
      'tags' => $this->tags->makeHidden('pivot'),
    ];
  }

  public function searchableAs()
  {
    return 'posts_index';
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

  protected function makeAllSearchableUsing($query)
  {
    return $query->with([
      'category',
      'tags' => function ($q) {
        $q->select(['tags.id', 'tags.name']);
      },
    ]);
  }

  public function scopeSort($query)
  {
    parent::scopeSort($query);

    $direction = request()->boolean('descending', true) ? 'ASC' : 'DESC';
    $order = request()->get('orderBy', 'id');

    if($order == 'title') {
        $query->join('post_translations', function($join) {
          $loc = app()->getLocale();
          $join->on('posts.id',  'post_translations.post_id');
          $join->on('locale',  DB::raw("'${loc}'"));
        });
        $query->select('posts.*','post_translations.title as t_title');
        $query->orderBy('t_title', $direction);
    }
  }
}
