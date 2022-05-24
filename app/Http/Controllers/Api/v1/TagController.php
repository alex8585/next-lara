<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

    return new TagCollection(Tag::filter()->paginate($perPage));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
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
   * @param \Illuminate\Http\Request $request
   *
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
