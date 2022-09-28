<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;
use App\Http\Resources\TagCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TagRepository extends BaseRepository
{
    /**
     * TagRepository constructor.
     *
     * @param Tag $model
     */
    public function __construct()
    {
        parent::__construct(Tag::class);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function paginate($perPage): TagCollection
    {
        $paginated =  $this->baseQuery()->paginate($perPage);
        return new TagCollection($paginated);
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
                })
            ),
        ]);
    }
}
