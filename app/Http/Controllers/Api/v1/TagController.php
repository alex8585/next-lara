<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagCollection;
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function show(Tag $tag)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function edit(Tag $tag)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Tag $tag)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tag $tag)
  {
    //
  }
}
