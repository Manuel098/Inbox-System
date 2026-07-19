<?php

namespace App\Services\Notify;

// Contract
use App\Interfaces\Notify\NotificationServiceInterface;
// DTOs
use App\DTOs\Notify\NotificationFiltersData;
use App\DTOs\Notify\NewNotificationMessageData;
// Models
use App\Models\User;
// Notify
use App\Notifications\NewMessageNotification;

class NotificationService implements NotificationServiceInterface
{
    /**
     * Obtiene las notificaciones no leídas del usuario de forma paginada y ordenada.
     *
     * @param \App\DTOs\Notify\NotificationFiltersData $dto Datos de filtrado y paginación.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Notificaciones pendientes paginadas.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el usuario no existe.
     */
    public function list(NotificationFiltersData $dto)
    {
        return User::findOrFail($dto->userId)
            ->unreadNotifications()
            ->latest()
            ->paginate($dto->perPage);
    }

    /**
     * Envía una notificación de nuevo mensaje al destinatario correspondiente.
     *
     * @param \App\DTOs\Notify\NewNotificationMessageData $dto Datos del mensaje y actores involucrados.
     * @return void
     */
    public function NewNotification(NewNotificationMessageData $dto) {
        $dto->recipient->notify(
            new NewMessageNotification( sender: $dto->sender, thread: $dto->thread, message: $dto->message )
        );
    }
}