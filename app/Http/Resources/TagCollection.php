<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Astrotomic\Translatable\Locales;

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

    $user = Auth::user();
    $can_create = $can_update = $can_delete = false;
    if($user) { 
        $can_create = $user->can('create', Tag::class);
        $can_update = $user->can('update', $tag);
        $can_delete = $user->can('delete', $tag);
    }

    $locales = app()->make('Astrotomic\Translatable\Locales')->all();
    /* $locales =     array_keys(LaravelLocalization::getSupportedLocales()) ; */ 

    return [
      'data' => $this->collection,
      'metaData' => [
        'locales'=> $locales,
        'locale' => app()->currentLocale(),
        'rowsNumber' => $this->total(),
        'rowsPerPage' => $this->perPage(),
        'page' => $this->currentPage(),
        'can_create' => $can_create,
        'can_update' =>$can_update,
        'can_delete' =>$can_delete,
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
