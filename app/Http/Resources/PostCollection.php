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

    ob_start();
    $test  =__('common.test');
    ob_end_clean();

    $post = new Post();
    $user = Auth::user();
    $can_create = $can_update = $can_delete = false;
    if($user) { 
        $can_create = $user->can('create', Post::class);
        $can_update = $user->can('update', $post);
        $can_delete = $user->can('delete', $post);
    }
    return [
      'data' => $this->collection,
      'metaData' => [
        'test'=> $test,
        'locale' => app()->currentLocale(),
        'rowsNumber' => $this->total(),
        'rowsPerPage' => $this->perPage(),
        'page' => $this->currentPage(),
        'can_create' => $can_create, 
        'can_update' => $can_update,
        'can_delete' => $can_delete,
      ],
    ];
  }

  public function withResponse($request, $response)
  {
    $response->header('X-Value', '11111');
    $response->header('Content-Type', 'application/json');

    $jsonResponse = json_decode($response->getContent(), true);
    unset($jsonResponse['links'], $jsonResponse['meta']);
    $response->setContent(json_encode($jsonResponse));
  }
}
