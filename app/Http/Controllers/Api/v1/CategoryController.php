<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\LocalesTrait;

class CategoryController extends Controller
{
    use LocalesTrait;

    public function __construct()
    {
        /* $this->authorizeResource(Category::class, 'category'); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = min(100, (int) request()->get('perPage', 5));

        $query = Category::queryFilter()->sort();

        if ($perPage > -1) {
            $query = $query->paginate($perPage);

            return new CategoryCollection($query);
        }

        return $query->get();
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
        $data = $this->formatLocalesFields($request->validated());
        $category = Category::create($data);

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
        $data = $this->formatLocalesFields($request->validated());
        $category->update($data);

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
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully!',
            'id' => $category->id,
        ]);
    }
}
