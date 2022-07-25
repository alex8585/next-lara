<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Model as Model;
use Illuminate\Support\Facades\DB;
use App\Facades\TransHelp;

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

    public static function queryFilter()
    {
      return QueryBuilder::for(self::class)->allowedFilters([
          AllowedFilter::exact('id'),
          AllowedFilter::callback(
              'name',
              fn ($query, $name) => $query->whereHas('translations', function ($query) use ($name) {
                $query->where('locale', app()->getLocale());
                $query->where('name', 'LIKE', "%{$name}%");
            })
          ),
      ]);
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
