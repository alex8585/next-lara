<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
  /**
   * Transform the resource collection into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'data' => $this->collection,
    ];
  }

  public function withResponse($request, $response)
  {
    $response->header('X-Value', '22222');
  }
  public function with($request)
  {
    return [
      'key' => 'value',
      'meta' => [
        'self' => 'link-value',
      ],
    ];
  }
}
