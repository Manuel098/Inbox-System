<?php

namespace App\Services\Thread;

use Illuminate\Support\Facades\DB;
use App\Exceptions\AuthorizationException;
// DTOs
use App\DTOs\Thread\ThreadFiltersData;
use App\DTOs\Thread\StoreThreadData;
use App\DTOs\Thread\StoreMessageData;
use App\DTOs\Notify\NewNotificationMessageData;
// Models
use App\Models\Thread;
use App\Models\Message;
// Actions
use App\Actions\Notify\SendMessageAction;

class ThreadService
{
    /**
     * Filtra y pagina los hilos de discusión a los que el usuario está suscrito.
     *
     * Aplica filtros dinámicos por término de búsqueda y estado, cargando además
     * el contador de mensajes y las relaciones del creador y último mensaje.
     *
     * @param  ThreadFiltersData  $payload  Objeto de datos con los criterios de filtrado y paginación.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<Thread>  Colección paginada de hilos ordenados por fecha del último mensaje.
     */
    public function paginate( ThreadFiltersData $payload ) {
        return Thread::query()
            ->whereHas('users', function ($query) {
                $query->where('users.id', auth()->id());
            })->when(
                $payload->search,
                fn($query)=>$query->where('subject', 'like', "%{$payload->search}%")
            )->when(
                $payload->status,
                fn($query)=>$query->where('status', $payload->status)
            )->with([
                'creator',
                'latestMessage.user'
            ])->withCount('messages')
            ->latest('last_message_at')
            ->paginate($payload->perPage);
    }

    /**
     * Muestra un hilo cargando sus relaciones y actualiza la última lectura del usuario.
     *
     * @param  Thread  $thread  Instancia del hilo obtenida por Route Model Binding.
     * @return Thread  Modelo del hilo con las relaciones 'creator', 'users' y 'messages.user' cargadas.
     *
     * @throws \Illuminate\Database\Eloquent\ModelThreadResource NotFoundException Si el hilo no existe.
     */
    public function show( Thread $thread ) {
        $thread->load([ 'creator', 'users', 'messages.user' ]);

        $this->validateAccess($thread);
        $thread->users()
            ->updateExistingPivot(auth()->id(), [ 'last_read_at'=>now() ]);

        return $thread;
    }

    public function store(StoreThreadData $payload): Thread {
        $thread = DB::transaction(function () use ($payload) {
            // Create new Thread
            $thread = Thread::create([
                'created_by' => $payload->user->id,
                'subject' => $payload->subject,
                'last_message_at' => now()
            ]);
            return $thread->load([ 'creator', 'users', 'messages.user' ]);
        });
        // Push message
        $this->pushMessage($thread, $payload);
        return $thread;
    }

    public function storeMessage(StoreMessageData $payload): Message
    {
        $this->validateAccess($payload->thread);
        return $this->pushMessage($payload->thread, $payload);
    }

    private function validateAccess(Thread $thread) {
        $userId = auth()->id();
        $hasAccess = ($thread->created_by === $userId) || ($thread->users()->where('users.id', $userId)->exists());

        if (! $hasAccess) {
            throw new AuthorizationException('No permissions to access on this three.');
        }

    }

    private function pushMessage(Thread $thread, $payload): Message
    {
        [$thread, $message] = DB::transaction(function () use ($thread, $payload) {
            // Update Last read
            $thread->users()
                ->updateExistingPivot(auth()->id(), [ 'last_read_at'=>now() ]);

            $thread->update(['last_message_at', now()]);
            
            // Push new message on thread
            $message = $thread->messages()->create([
                'user_id' => auth()->id(),
                'body' => $payload->message,
            ]);
            
            return [$thread, $message];
        });

        // Notify Participants
        $this->notify($thread, $message);

        return $message;
    }

    /**
     * Notifica a todos los participantes de un hilo sobre un nuevo mensaje
     * excluyendo al usuario que originó la acción.
     *
     * @param \App\Models\Thread $thread Instancia del hilo de conversación.
     * @param \App\Models\Message $message Instancia del mensaje enviado.
     * @param int $senderId ID del usuario que envía el mensaje (por defecto el usuario autenticado).
     * @return void
     */
    private function notify(Thread $thread, Message $message): void
    {
        $participants = $thread->participantsExcept(auth()->id());
        $action = app(SendMessageAction::class);
        $participants->each(function ($user) use ($action, $thread, $message) {
            $action( NewNotificationMessageData::fromCall($user, $thread, $message) );
        });
    }
}
