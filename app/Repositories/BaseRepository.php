<?php

namespace App\Repositories;

use App\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LocalesTrait;

class BaseRepository implements EloquentRepositoryInterface
{
    use LocalesTrait;

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        $data = $this->formatLocalesFields($attributes);
        return $this->model->create($data);
    }
 
    public function update(Model $model, array $attributes): bool
    {
        $data = $this->formatLocalesFields($attributes);
        return $model->update($data);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
}
