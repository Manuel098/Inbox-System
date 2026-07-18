<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserResource;
use App\Http\Resources\MessageResource;

class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'subject'           => $this->subject,
            'status'            => $this->status,
            'creator'           => new UserResource( $this->whenLoaded('creator') ),
            'participants'      => UserResource::collection( $this->whenLoaded('users') ),
            'messages'          => MessageResource::collection( $this->whenLoaded('messages') ),
            'messages_count'    => $this->messages_count,
            'last_message_at'   => $this->last_message_at

        ];

    }
}
