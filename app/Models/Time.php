<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Model;
class Time extends Model
{
  protected $casts = [
    'Tz' => 'datetime:Y-m-d',
  ];
  use HasFactory;
}
