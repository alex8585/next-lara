<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;
use   Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class PostController extends Controller
{
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
        /* dd(LaravelLocalization::getSupportedLocales() ); */
        /* dd(response()); */
        $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

        $filter = request()->query('filter', null);

        $q = $filter['q'] ?? null;

        if ($q) {
            $query = Post::search($q)
            ->query(function ($query) {
                Post::queryFilter($query)
                ->with(['tags', 'category'])
                ->sort();
            })->paginate($perPage);
        } else {
            $query = Post::queryFilter()
            ->with(['tags', 'category'])
            ->sort()
            ->paginate($perPage);
        }

        return new PostCollection($query);

        /* return new PostCollection(Post::with(['tags', 'category'])->paginate(5)); */
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
        $post = Post::create($validated->all());

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
        $post->update($validated->all());

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
