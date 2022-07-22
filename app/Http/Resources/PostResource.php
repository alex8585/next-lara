<?php

namespace App\Http\Resources;

use App\Facades\TimeConverter as Tc;
/* use App\Support\TimeConverter; */
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public static $wrap;

  public function toArray($request)
  {
    /* $tc = new TimeConverter(); */
    /* dd($this); */
    $created_at = Tc::toTimezone($this->created_at);
    $updated_at = Tc::toTimezone($this->updated_at);

    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'title' => $this->title,
      'description' => $this->description,
      'created_at_str' => $created_at,
      'updated_at_str' => $updated_at,
      'created_at' => Tc::toTimestamp($created_at),
      'updated_at' => Tc::toTimestamp($updated_at),
      'tags' => TagResource::collection($this->tags),
      'category' => new CategoryResource($this->category),
    ];
  }
}
