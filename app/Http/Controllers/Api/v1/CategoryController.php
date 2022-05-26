<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $perPage = max(min(100, (int) request()->get('perPage', 5)), 5);

    $query = Category::queryFilter()
      ->sort()
      ->paginate($perPage);

    return new CategoryCollection($query);

    //
    //   return new CategoryCollection(Category::paginate(5));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCategoryRequest $request)
  {
    $category = Category::create($request->validated());

    return response()->json([
      'message' => 'Category created successfully!',
      'id' => $category->id,
    ]);
    //
  }

  /**
   * Display the specified resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    return new CategoryResource($category);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function update(StoreCategoryRequest $request, Category $category)
  {
    $category->update($request->validated());

    return response()->json([
      'message' => 'Category updated successfully!',
      'id' => $category->id,
    ]);
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    //
    $category->delete();

    return response()->json([
      'message' => 'Category deleted successfully!',
      'id' => $category->id,
    ]);
  }
}
