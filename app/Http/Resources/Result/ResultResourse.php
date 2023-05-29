<?php

namespace App\Http\Resources\Result;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // dd($this);
        return [
            'id' => $this->id,
            'coast' => $this->coast,
            'message' => $this->message->message,
            'category_id' => $this->category_id,
            'category' => $this->category,
          //  'page' => $this->page,
          //  'per_page' => $this->per_page
        ];
    }
}
