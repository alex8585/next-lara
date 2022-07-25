<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
        $params = explode('/', $request->path());

        $returnArray = ['id' => $this->id];
        
        if (isset($params[3]) && $params[3] == 'categories') {
            $returnArray['tr'] = $this->getTranslationsArray();
        } else {
            $returnArray['name'] = $this->name;
        }

        return $returnArray;
    }
}
