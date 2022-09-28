<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Http\Resources\CategoryCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryRepository extends BaseRepository
{
    /**
     * TagRepository constructor.
     *
     * @param Tag $model
     */
    public function __construct()
    {
        parent::__construct(Category::class);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function paginate($perPage): CategoryCollection
    {
        $paginated =  $this->baseQuery()->paginate($perPage);
        return new CategoryCollection($paginated);
    }

    private function baseQuery(): QueryBuilder
    {
        return $this->queryFilter()->with('translations')->sort();
    }

    private function queryFilter()
    {
        return QueryBuilder::for($this->model)->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::callback(
                'name',
                fn ($query, $name) => $query->whereHas('translations', function ($query) use ($name) {
                    $query->where('locale', app()->getLocale());
                    $query->where('name', 'LIKE', "%{$name}%");
                    /* $query->where(DB::raw('LOWER(category_translations.name)') , 'LIKE', '%' . strtolower($name) . '%'); */
                })
            ),
        ]);
    }
}
