<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class TagCollection extends ResourceCollection
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
    $tag = new Tag();

    return [
      'data' => $this->collection,
      'metaData' => [
        'rowsNumber' => $this->total(),
        'rowsPerPage' => $this->perPage(),
        'page' => $this->currentPage(),
        'can_create' => Auth::user()->can('create', Tag::class),
        'can_update' => Auth::user()->can('update', $tag),
        'can_delete' => Auth::user()->can('delete', $tag),
      ],
    ];

    /* return parent::toArray($request); */
  }

  public function withResponse($request, $response)
  {
    $jsonResponse = json_decode($response->getContent(), true);
    unset($jsonResponse['links'], $jsonResponse['meta']);
    $response->setContent(json_encode($jsonResponse));
  }
}
