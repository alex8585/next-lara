<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

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
    return [
      'data' => $this->collection,
      'metaData' => [
        'rowsNumber' => $this->total(),
        'rowsPerPage' => $this->perPage(),
        'page' => $this->currentPage(),
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
