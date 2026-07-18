<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Thread;
// REQUESTS
use App\Http\Requests\Thread\IndexThreadRequest;
use App\Http\Requests\Thread\StoreMessageRequest;
use App\Http\Requests\Thread\StoreThreadRequest;
// ACTIONS
use App\Actions\Thread\ListThreadsAction;
use App\Actions\Thread\ShowThreadAction;
use App\Actions\Thread\StoreMessageAction;
use App\Actions\Thread\StoreThreadAction;
// RESOURCES
use App\Http\Resources\ThreadCollection;
use App\Http\Resources\ThreadResource;
use App\Http\Resources\MessageResource;
// DTOs
use App\DTOs\Thread\ThreadFiltersData;
use App\DTOs\Thread\StoreMessageData;
use App\DTOs\Thread\StoreThreadData;

class ThreadController extends Controller
{
    /**
     * Obtiene y pagina los hilos a los que el usuario está suscrito.
     *
     * @param  IndexThreadRequest  $request  Petición validada con los filtros y paginación.
     * @param  ListThreadsAction  $action  Acción que ejecuta el servicio y la lógica de negocio para listar hilos.
     * @return ThreadCollection  Colección paginada y formateada de hilos.
     *
     * @throws \Exception Si ocurre un error inesperado durante la ejecución de la acción.
     */
    public function index(IndexThreadRequest $request, ListThreadsAction $action) {
        return ThreadCollection::make( $action(ThreadFiltersData::fromRequest($request)) );
    }

    /**
     * Muestra los detalles de un hilo de discusión específico.
     *
     * @param  Thread  $thread  Instancia del modelo del hilo obtenida por Route Model Binding.
     * @param  ShowThreadAction  $action  Acción que ejecuta el servicio y la lógica de negocio para consultar el hilo.
     * @return ThreadResource  Recurso formateado con los detalles del hilo.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el hilo no existe.
     * @throws \Exception Si ocurre un error inesperado durante la carga del hilo.
     */
    public function show( Thread $thread, ShowThreadAction $action ) {
        return ThreadResource::make( $action($thread) );
    }

    /**
     * Procesa la petición para crear y retornar un nuevo hilo.
     *
     * @param StoreThreadRequest <subject: string, message:string> $request Petición validada con los datos del nuevo hilo.
     * @param StoreThreadAction $action Acción que ejecuta el servicio y la lógica de negocio para crear el hilo.
     * @return ThreadResource Recurso que formatea los datos del hilo creado para la respuesta.
     *
     * @throws \Exception Si ocurre un error inesperado durante el flujo de creación.
     */
    public function store( StoreThreadRequest $request, StoreThreadAction $action ) {
        $thread = $action( StoreThreadData::fromRequest($request) );
        return new ThreadResource($thread);
    }

    /**
     * Procesa la petición para crear y retornar un nuevo mensaje dentro de un hilo.
     *
     * @param StoreMessageRequest <message: string> $request Petición validada con los datos del nuevo mensaje.
     * @param Thread $thread Instancia del hilo al que pertenecerá el mensaje.
     * @param StoreMessageAction $action Acción que ejecuta el servicio y la lógica de negocio para crear el mensaje.
     * @return MessageResource Recurso que formatea los datos del mensaje creado para la respuesta.
     *
     * @throws \Exception Si ocurre un error inesperado durante el flujo de creación.
     */
    public function storeMessage( StoreMessageRequest $request, Thread $thread, StoreMessageAction $action )
    {
        $message = $action( StoreMessageData::fromRequest($request, $thread) );
        return new MessageResource($message);
    }
}
