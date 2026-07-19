<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transforma el recurso de la notificación en un array para la respuesta JSON.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP entrante.
     * @return array{
     *     id:          int|string,
     *     sender:      array{id: int|null, name: string|null},
     *     type:        string,
     *     title:       string|null,
     *     body:        string|null,
     *     thread_id:   int|string|null,
     *     message_id:  int|string|null,
     *     read:        bool,
     *     created_at:  \Carbon\Carbon|\DateTimeInterface
     * } Estructura detallada del recurso de la notificación.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'sender'     => [ 'id' => $this->data['sender']['id'] ?? null, 'name' => $this->data['sender']['name'] ?? null ],
            'type'       => class_basename($this->type),
            'title'      => $this->data['title'] ?? null,
            'body'       => $this->data['body'] ?? null,
            'thread_id'  => $this->data['thread_id'] ?? null,
            'message_id' => $this->data['message_id'] ?? null,
            'read'       => ! is_null($this->read_at),
            'created_at' => $this->created_at,
        ];
    }
}
