<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewMessageResource extends JsonResource
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
            "content" => $this->content,
            "user_id" => $this->user_id,
            "conversation_id" => $this->conversation_id,
            "created_at" => $this->created_at,
            "id" => $this->id,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "email" => $this->user->email,
            ],
            "conversation" => new UserConversationResource($this->whenLoaded('conversation'))
        ];
    }
}
