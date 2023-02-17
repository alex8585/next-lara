<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use App\Facades\TransHelp;

class NotificationCollection extends ResourceCollection
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
        $notif = new Notification();

        $user = Auth::user();
        $can_create = $can_update = $can_delete = false;
        if ($user) {
            $can_create = $user->can('create', Notification::class);
            $can_update = $user->can('update', $notif);
            $can_delete = $user->can('delete', $notif);
        }
        return [
          'data' => $this->collection,
          'metaData' => [
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
