<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as Qbuilder;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection as Ecollection;
use Illuminate\Support\Collection;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Facades\TimeConverter;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new PostCollection(Post::with(['tags', 'category'])->paginate(5));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePostRequest $request)
  {
    $post = Post::create($request->all());

    return response()->json(
      [
        'status' => true,
        'message' => 'Post Created successfully!',
        'post' => $post,
      ],
      200
    );
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(StorePostRequest $request, Post $post)
  {
    //
    $post->update($request->all());

    return response()->json(
      [
        'status' => true,
        'message' => 'Post Updated successfully!',
        'post' => $post,
      ],
      200
    );
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    //
    $post->delete();

    return response()->json(
      [
        'status' => true,
        'message' => 'Post Deleted successfully!',
      ],
      200
    );
  }
}
