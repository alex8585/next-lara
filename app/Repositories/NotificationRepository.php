<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Collection;
use App\Http\Resources\NotificationCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;

class NotificationRepository extends BaseRepository
{
    /**
     * TagRepository constructor.
     *
     * @param Tag $model
     */
    public function __construct()
    {
        parent::__construct(Notification::class);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }

    public function paginate($perPage): NotificationCollection
    {
        $paginated =  $this->baseQuery()->paginate($perPage);
        return new NotificationCollection($paginated);
    }

    private function baseQuery(): QueryBuilder
    {
        /* return $this->queryFilter()->with(['symbol' => function ($q) { */
        /*     return $q->select(['id','base']); */
        /* }])->sort(); */

        return $this->queryFilter()
             ->select(['notifications.*','symbols.base'])
                  ->join('symbols', 'notifications.symbol_id', '=', 'symbols.id')
                  ->sort();
    }

    private function queryFilter()
    {
        return QueryBuilder::for($this->model)->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::partial('symbol'),
            AllowedFilter::partial('price'),
        ]);
    }
}
