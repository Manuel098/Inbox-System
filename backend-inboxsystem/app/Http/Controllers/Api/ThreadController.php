<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Thread\IndexThreadRequest;
use App\Models\Thread;
use App\Actions\Thread\ListThreadsAction;
use App\Actions\Thread\ShowThreadAction;
use App\Http\Resources\ThreadCollection;
use App\Http\Resources\ThreadResource;
use App\DTOs\Thread\ThreadFiltersData;

class ThreadController extends Controller
{
    /**
     * Obtiene y pagina los hilos a los que el usuario está suscrito.
     *
     * @param  IndexThreadRequest  $request  Petición validada con los filtros y paginación.
     * @param  ListThreadsAction  $action  Acción que ejecuta la lógica de negocio para listar hilos.
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
     * @param  ShowThreadAction  $action  Acción que ejecuta la lógica de negocio para consultar el hilo.
     * @return ThreadResource  Recurso formateado con los detalles del hilo.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el hilo no existe.
     * @throws \Exception Si ocurre un error inesperado durante la carga del hilo.
     */
    public function show( Thread $thread, ShowThreadAction $action ) {
        return ThreadResource::make( $action($thread) );
    }
}
