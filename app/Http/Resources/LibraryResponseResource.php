<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LibraryResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response =  [
            'id' => $this['id'],
            'name' => $this['name']
        ];

        if ($this->relationLoaded('books')) $response['books'] = BookResponseResource::collection($this['books']);
        if ($this->relationLoaded('pivot')) $response["existing_count"] = $this['pivot']->existing_count;
        return $response;
    }
}
