<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
  use HasFactory;

  public function posts()
  {
    return $this->belongsToMany(Post::class);
  }

  public function scopeFilter($query)
  {
    $direction = request()->boolean('descending', true) ? 'ASC' : 'DESC';
    $order = request()->get('orderBy', 'id');

    $isIn = in_array($order, ['id', 'name']);

    $query->when($isIn, function ($query) use ($order, $direction) {
      $query->orderBy($order, $direction);
    });
  }
}
