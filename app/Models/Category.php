<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Astrotomic\Translatable\Translatable;
use App\Facades\TransHelp;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use Translatable;
    use HasFactory;

    protected $sortFields = ['id', 'name'];

    public $translatedAttributes = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeSort($query)
    {
        parent::scopeSort($query);

        $direction = request()->boolean('descending', true) ? 'ASC' : 'DESC';
        $order = request()->get('orderBy', 'id');

        if ($order == 'name') {
            $query->join('category_translations', function ($join) {
                $loc = app()->getLocale();
                $join->on('categories.id', 'category_translations.category_id');
                $join->on('locale', DB::raw("'${loc}'"));
            });
            $query->select('categories.*', 'category_translations.name as t_name');
            $query->orderBy('t_name', $direction);
        }
    }
}
