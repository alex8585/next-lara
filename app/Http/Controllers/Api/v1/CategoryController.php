<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
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

        if ($perPage > -1) {
            return $this->categoryRepo->paginate($perPage);
        }

        return $this->categoryRepo->all();
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
        $category = $this->categoryRepo->create($request->validated());
        return response()->json([
            'message' => 'Category created successfully!',
            'id' => $category->id,
        ]);
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
        $this->categoryRepo->update($category, $request->validated());
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
        $this->categoryRepo->delete($category);

        return response()->json([
            'message' => 'Category deleted successfully!',
            'id' => $category->id,
        ]);
    }
}
