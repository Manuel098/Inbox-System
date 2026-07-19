<?php

namespace App\Interfaces\Notify;

use App\DTOs\Notify\NotificationFiltersData;
use App\DTOs\Notify\NewNotificationMessageData;

interface NotificationServiceInterface
{
    /**
     * Obtiene una lista filtrada de notificaciones según los criterios del DTO.
     *
     * @param \App\DTOs\Notify\NotificationFiltersData $dto Objeto con los filtros aplicables.
     * @return \Illuminate\Pagination\LengthAwarePaginator Lista paginada de notificaciones.
     */
    public function list(NotificationFiltersData $dto);

    /**
     * Registra y envía una nueva notificación en el sistema.
     *
     * @param \App\DTOs\Notify\NewNotificationMessageData $dto Datos requeridos para la creación de la notificación.
     * @return \App\Models\Notification La entidad de la notificación creada.
     */
    public function NewNotification(NewNotificationMessageData $dto);
}
