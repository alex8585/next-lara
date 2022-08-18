<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    private $tagRepo;

    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
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

        if ($perPage > -1) {
            return $this->tagRepo->paginate($perPage);
        }

        return $this->tagRepo->all();
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
        $tag = $this->tagRepo->create($request->validated());

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
        /* $data = $this->formatLocalesFields($request->validated()); */

        $this->tagRepo->update($tag, $request->validated());

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
        $this->tagRepo->delete($tag);

        return response()->json([
            'message' => 'Tag deleted successfully!',
            'id' => $tag->id,
        ]);
    }
}
