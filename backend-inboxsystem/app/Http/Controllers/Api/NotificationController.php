<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Notify\IndexNotificationRequest;
use App\Actions\Notify\ListNotificationsAction;
use App\Http\Resources\NotificationCollection;
use App\DTOs\Notify\NotificationFiltersData;

class NotificationController extends Controller
{
    /**
     * Lista las notificaciones paginadas.
     *
     * @param \App\Http\Requests\IndexNotificationRequest $request Solicitud validada.
     * @param \App\Actions\ListNotificationsAction $action Acción que ejecuta la lógica de negocio y consulta.
     * @return \App\Http\Resources\NotificationCollection Colección de recursos de notificaciones formateada.
     */
    public function list( IndexNotificationRequest $request, ListNotificationsAction $action ): NotificationCollection
    {
        $notifications = $action(NotificationFiltersData::fromRequest($request));
        return new NotificationCollection($notifications);
    }
}
