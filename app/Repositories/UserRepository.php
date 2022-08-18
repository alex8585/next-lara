<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Resources\UserCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserRepository extends BaseRepository
{
    /**
     * TagRepository constructor.
     *
     * @param Tag $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function paginate($perPage): UserCollection
    {
        $paginated =  $this->baseQuery()->paginate($perPage);
        return new UserCollection($paginated);
    }

    private function baseQuery(): QueryBuilder
    {
        return $this->queryFilter()->sort();
    }

  private function queryFilter()
  {
      return QueryBuilder::for($this->model)->allowedFilters([
        AllowedFilter::exact('id'),
        AllowedFilter::partial('name'),
        AllowedFilter::partial('email'),
      ]);
  }
}
