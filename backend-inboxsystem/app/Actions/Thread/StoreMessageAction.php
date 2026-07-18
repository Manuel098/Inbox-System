<?php

namespace App\Actions\Thread;

use App\Models\Message;
use App\Services\Thread\ThreadService;
use App\DTOs\Thread\StoreMessageData;

class StoreMessageAction
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
     * @param StoreMessageData $data Objeto de transferencia de datos con la información del hilo.
     * @return Thread Instancia del hilo recién creado.
     *
     * @throws \Exception Si ocurre un error inesperado durante la creación del hilo.
     */
    public function __invoke( StoreMessageData $payload ) {
        return $this->service->storeMessage($payload);
    }
}
