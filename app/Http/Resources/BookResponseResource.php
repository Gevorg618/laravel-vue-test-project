<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResponseResource extends JsonResource
{
    public static $wrap = 'book';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            'id'          => $this['id'],
            'title'       => $this['title'],
            'description' => $this['description'],
            'author'      => $this['author'],
            'user_id'     => $this['user_id']
        ];

        if ($this->relationLoaded('libraries')) $response['libraries'] = LibraryResponseResource::collection($this['libraries']);
        if ($this->relationLoaded('likes')) $response['likes'] = $this['likes'];
        if ($this->relationLoaded('pivot')) $response["existing_count"] = $this['pivot']->existing_count;
        if (isset($this['liked'])) $response['liked'] = $this['liked'];

        return $response;
    }
}
