<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\PostRepository;
/* use Illuminate\Database\Eloquent\Builder; */
use Laravel\Scout\Builder;

class PostController extends Controller
{
    private $postRepo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
        /* $this->authorizeResource(Post::class, 'post'); */
    }

    public function index()
    {
        $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

        $filter = request()->query('filter', null);

        $q = $filter['q'] ?? null;

        if ($q) {
            return  $this->postRepo->search($q, $perPage);
        }

        return  $this->postRepo->paginate($perPage);
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
        $tags = $request->safe()->tags ?? [];
        
        $post = $this->postRepo->create($validated->all(), $tags);

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

        $this->postRepo->update($post, $validated->all(), $tags);

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
        $this->postRepo->delete($post);

        return response()->json([
            'message' => 'Post deleted successfully!',
            'id' => $post->id,
        ]);
    }
}
