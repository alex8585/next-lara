<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Prunable;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use App\Casts\Timestamp;

class Post extends Model
{
  use HasFactory;
  use Prunable;
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
    return $this->belongsToMany(Tag::class);
  }

  public function prunable()
  {
    return static::where('created_at', '<=', now()->subDays(3));
  }
  /* protected function serializeDate(DateTimeInterface $date) */
  /* { */
  /*   return $date->format('Y'); */
  /* } */
  /* protected function serializeDate(DateTimeInterface $date) */
  /* { */
  /*   return Carbon::instance($date)->toIso8601String(); */
  /*   /1* return $date; *1/ */
  /*   /1* return '1111'; *1/ */
  /*   /1* return $date->getTimestamp(); *1/ */
  /*   /1* return $date; *1/ */
  /*   /1* return $date->format('H:i:s'); *1/ */
  /*   /1* return $date->timezone('Europe/Kiev')->getTimestamp(); *1/ */
  /* } */
}
