<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            "message" => isset($this['message']) ? $this['message'] : '',
            "type"    => isset($this['type']) ? $this['type'] : 'success',
            "success" => isset($this['success']) ? $this['success'] : 1,
        ];
        if (isset($this['user'])) $response['user'] = $this['user'];
        if (isset($this['token'])) $response['token'] = $this['token'];

        return $response;
    }
}
