<?php

namespace App\Actions\Thread;

use App\DTOs\Thread\StoreThreadData;
use App\Services\Thread\ThreadService;
use App\Models\Thread;

class StoreThreadAction
{
    private ThreadService $service;
    /**
     * Create a new class instance.
     */
    public function __construct( ThreadService $service ) {
        $this->service = $service;
    }

    /**
     * Crea y almacena un nuevo hilo en el sistema.
     *
     * @param StoreThreadData $data Objeto de transferencia de datos con la información del hilo.
     * @return Thread Instancia del hilo recién creado.
     *
     * @throws \Exception Si ocurre un error inesperado durante la creación del hilo.
     */
    public function __invoke( StoreThreadData $payload ) {
        return $this->service->store($payload);
    }
}
