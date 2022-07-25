<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\LocalesTrait;

/* use Illuminate\Database\Eloquent\Builder; */
use Laravel\Scout\Builder;

class PostController extends Controller
{
    use LocalesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        /* $this->authorizeResource(Post::class, 'post'); */
    }

    public function index()
    {
        $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

        $filter = request()->query('filter', null);

        $q = $filter['q'] ?? null;

        $postsQuery = Post::queryFilter()
            ->with('translations')
            ->with(['tags'=> function($q){
                $q->with('translation');
            }])
            ->with(['category'=> function($q){
                $q->with('translation');
            }])->sort();

        if($q) {
            $hits = Post::search($q)->raw()['hits'];
            $postsIds = array_column($hits,'id');
            $postsQuery->whereIn('id',$postsIds);
        }
        /* if ($q) { */
        /*     $searchQuery = Post::search($q)->query(function ($query) use ($baseQuery) { */
        /*         $eager = $baseQuery->getEagerLoads(); */
        /*         Post::queryFilter($query)->setEagerLoads($eager)->sort(); */
        /*     }); */
        /*     $postsQuery = $searchQuery->paginate($perPage); */
        /* } else { */
        /*     $postsQuery = $baseQuery->paginate($perPage); */
        /* } */

        return new PostCollection($postsQuery->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->safe();

        $validated['category_id'] = $request->safe()->category['value'] ?? null;
        $validated['user_id'] = 1;

        $tags = $request->safe()->tags ?? null;

        $data = $this->formatLocalesFields($validated);
        $post = Post::create($data);

        if ($tags) {
            if (isset($tags[0]['value'])) {
                $tagsIds = collect($tags)->pluck('value');
            } else {
                $tagsIds = collect($tags);
            }
            $post->tags()->sync($tagsIds);
        }

        return response()->json([
          'message' => 'Post created successfully!',
          'id' => $post->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $validated = $request->safe()->merge([
          'category_id' => $request->safe()->category['value'] ?? null,
          'user_id' => 1,
         ]);

        $tags = $request->safe()->tags ?? null;

        $data = $this->formatLocalesFields($validated);
        $post->update($data);

        if ($tags) {
            if (isset($tags[0]['value'])) {
                $tagsIds = collect($tags)->pluck('value');
            } else {
                $tagsIds = collect($tags);
            }
            $post->tags()->sync($tagsIds);
        }

        return response()->json([
          'message' => 'Post updated successfully!',
          'id' => $post->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
      'message' => 'Post deleted successfully!',
      'id' => $post->id,
    ]);
    }
}
