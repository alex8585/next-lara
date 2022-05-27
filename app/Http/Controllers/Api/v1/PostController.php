<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

    $query = Post::queryFilter()
      ->with(['tags', 'category'])
      ->sort()
      ->paginate($perPage);

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
    $validated = $request->safe(['title', 'description']);
    $validated['user_id'] = 1;

    $tagsIds = collect($request->safe()->tags)->pluck('value');
    /* dd($validated); */
    $post = Post::create($validated);
    $post->tags()->sync($tagsIds);

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
      'user_id' => 1,
    ]);

    $tagsIds = collect($request->safe()->tags)->pluck('value');

    $post->update($validated->all());
    $post->tags()->sync($tagsIds);

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
