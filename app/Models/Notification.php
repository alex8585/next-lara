<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as Model;
use App\Models\Symbol;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['symbol' ];

    public function symbol()
    {
        return $this->belongsTo(Symbol::class) ;
    }
}
