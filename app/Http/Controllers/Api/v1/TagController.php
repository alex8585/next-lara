<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Traits\LocalesTrait;

class TagController extends Controller
{
    use LocalesTrait;

    public function __construct()
    {

        /* $this->authorizeResource(Tag::class, 'tag'); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = min(100, (int) request()->get('perPage', 5));

        $query = Tag::queryFilter()->with('translations')->sort();

        if ($perPage > -1) {
            $query = $query->paginate($perPage);

            return new TagCollection($query);
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
    public function store(StoreTagRequest $request)
    {
        $data = $this->formatLocalesFields($request->validated());
        $tag = Tag::create($data);
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
        $data = $this->formatLocalesFields($request->validated());
        $tag->update($data);

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
