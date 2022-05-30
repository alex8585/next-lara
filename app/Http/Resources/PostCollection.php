<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $post = new Post();

    return [
      'data' => $this->collection,
      'metaData' => [
        'rowsNumber' => $this->total(),
        'rowsPerPage' => $this->perPage(),
        'page' => $this->currentPage(),
        'can_create' => Auth::user()->can('create', Post::class),
        'can_update' => Auth::user()->can('update', $post),
        'can_delete' => Auth::user()->can('delete', $post),
      ],
    ];
  }

  public function withResponse($request, $response)
  {
    $jsonResponse = json_decode($response->getContent(), true);
    unset($jsonResponse['links'], $jsonResponse['meta']);
    $response->setContent(json_encode($jsonResponse));
  }
}
