<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category->title,
            'category_id' => $this->category_id,
          //  'page' => $this->page,
          //  'per_page' => $this->per_page
        ];
    }
}
