<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
     //   dd($request->session()->get('chat_id'));
        return [
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->created_at->format('d-m-Y'),
           // 'coast' => array($this->message->results)
            'coast' => $this->results,
        ];
    }
}
