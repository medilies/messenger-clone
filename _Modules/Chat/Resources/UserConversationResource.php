<?php

namespace _Modules\Chat\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserConversationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'name' => $this->name,
            'visibility' => $this->visibility,
            'other_users' => OtherUsersResource::collection($this->whenLoaded('otherUsers')),
        ] +
            ($this->type === 'direct' ?
                [] :
                ['pivot' => [
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                ]]);
    }
}
