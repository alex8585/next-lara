<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Facades\TimeConverter as Tc;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = null;

    public function toArray($request)
    {
        /* return parent::toArray($request); */

        $created_at = Tc::toTimezone($this->created_at);
        $updated_at = Tc::toTimezone($this->updated_at);

        return [
            'id' => $this->id,
            'symbol_id' => $this->symbol_id,
            'symbol' => $this->base,
            'price' => $this->price,
            'direction' => $this->direction,

            'created_at' => Tc::toTimestamp($created_at),
            'updated_at' => Tc::toTimestamp($updated_at),
        ];
    }
}
