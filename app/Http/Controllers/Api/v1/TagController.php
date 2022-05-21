<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagCollection;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
class TagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    return new TagCollection(Tag::paginate(5));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTagRequest $request)
  {
    $tag = Tag::create($request->validated());
    return response()->json([
      'message' => 'Tag created successfully!',
      'id' => $tag->id,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function show(Tag $tag)
  {
    return new TagResource($tag);

    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function update(StoreTagRequest $request, Tag $tag)
  {
    $tag->update($request->validated());
    return response()->json([
      'message' => 'Tag updated successfully!',
      'id' => $tag->id,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tag $tag)
  {
    $tag->delete();

    return response()->json([
      'message' => 'Tag deleted successfully!',
      'id' => $tag->id,
    ]);
  }
}
