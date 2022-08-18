<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Model as Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    use HasFactory ;
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $sortFields = ['id'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function scopeSort($query)
    {
        parent::scopeSort($query);

        $direction = request()->boolean('descending', true) ? 'ASC' : 'DESC';
        $order = request()->get('orderBy', 'id');

        if ($order == 'name') {
            $query->join('tag_translations', function ($join) {
                $loc = app()->getLocale();
                $join->on('tags.id', 'tag_translations.tag_id');
                $join->on('locale', DB::raw("'${loc}'"));
            });
            $query->select('tags.*', 'tag_translations.name as t_name');
            $query->orderBy('t_name', $direction);
        }
    }
}
