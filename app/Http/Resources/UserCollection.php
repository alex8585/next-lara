<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserCollection extends ResourceCollection
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
        $user = new User();

        return [
          'data' => $this->collection,
          'metaData' => [
            'rowsNumber' => $this->total(),
            'rowsPerPage' => $this->perPage(),
            'page' => $this->currentPage(),
            'can_create' => Auth::user()->can('create', User::class),
            'can_update' => Auth::user()->can('update', $user),
            'can_delete' => Auth::user()->can('delete', $user),
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
