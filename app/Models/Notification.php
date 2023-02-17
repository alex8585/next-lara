<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model as Model;
use App\Models\Symbol;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['symbol' ];

    protected $sortFields = ['price'];

    public function symbol()
    {
        return $this->belongsTo(Symbol::class) ;
    }

    public function scopeSort($query)
    {
        $direction = request()->boolean('descending', true) ? 'ASC' : 'DESC';
        $order = request()->get('orderBy', 'id');

        $isIn = in_array($order, $this->sortFields);

        $query->when($isIn, function ($query) use ($order, $direction) {
            $query->orderBy($order, $direction);
        });

        if ($order == 'symbol') {
            $query->orderBy('base', $direction);
        }
    }
}
