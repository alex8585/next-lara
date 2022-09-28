<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;
use App\Http\Resources\PostCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository
{
    /**
     * PostRepository constructor.
     *
     * @param Post $model
     */
    public function __construct()
    {
        parent::__construct(Post::class);
    }

    /**
     * @return Collection
     */
    public function search($q, $perPage): PostCollection
    {
        $hits = $this->model->search($q)->raw()['hits'];
        $postsIds = array_column($hits, 'id');

        $paginated = $this->baseQuery()->whereIn('id', $postsIds)->paginate($perPage);
        return new PostCollection($paginated);
    }

    public function paginate($perPage): PostCollection
    {
        $paginated =  $this->baseQuery()->paginate($perPage);
        return new PostCollection($paginated);
    }

    public function create(array $attributes, $tags = []): Model
    {
        $data = $this->formatLocalesFields($attributes);
        $post =  $this->model->create($data);

        if ($tags) {
            if (isset($tags[0]['value'])) {
                $tagsIds = collect($tags)->pluck('value');
            } else {
                $tagsIds = collect($tags);
            }
            $post->tags()->sync($tagsIds);
        }
        return $post;
    }

    public function update(Model $post, array $attributes, $tags = []): bool
    {
        $data = $this->formatLocalesFields($attributes);
        $result = $post->update($data);
        if ($tags) {
            if (isset($tags[0]['value'])) {
                $tagsIds = collect($tags)->pluck('value');
            } else {
                $tagsIds = collect($tags);
            }
            $post->tags()->sync($tagsIds);
        }

        return $result;
    }

    private function baseQuery(): QueryBuilder
    {
        return $this->queryFilter()
            ->with('translations')
            ->with(['tags' => function ($q) {
                $q->with('translation');
            }])
            ->with(['category' => function ($q) {
                $q->with('translation');
            }])->sort();
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
