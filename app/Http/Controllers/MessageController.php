<?php

namespace App\Http\Controllers;

use App\Events\NewMessageSent;
use App\Models\Ticket;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Pobiera wiadomości dla danego zgłoszenia.
     */
    #[OA\Get(
        path: "/api/tickets/{ticket}/messages",
        operationId: "getMessages",
        summary: "Pobiera wiadomości zgłoszenia",
        description: "Zwraca listę wiadomości przypisanych do konkretnego zgłoszenia.",
        tags: ["Wiadomości"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "ticket", in: "path", required: true, description: "ID zgłoszenia", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista wiadomości.", content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/MessageFull"))),
            new OA\Response(response: 403, description: "Brak uprawnień.")
        ]
    )]
    public function index(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return response()->json($ticket->messages()->with('sender')->latest()->get());
    }

    /**
     * Zapisuje nową wiadomość do zgłoszenia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: "/api/tickets/{ticket}/messages",
        operationId: "createMessage",
        summary: "Dodaje nową wiadomość do zgłoszenia",
        description: "Umożliwia zalogowanemu użytkownikowi dodanie nowej wiadomości (komentarza) do istniejącego zgłoszenia. Użytkownik musi mieć uprawnienia do interakcji ze zgłoszeniem.",
        tags: ["Wiadomości"],
        security: [
            ["bearerAuth" => []]
        ],
        parameters: [
            new OA\Parameter(name: "ticket", in: "path", required: true, description: "ID zgłoszenia", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Treść nowej wiadomości.",
            content: new OA\JsonContent(
                required: ["body"],
                properties: [
                    new OA\Property(property: "body", type: "string", example: "Próbowałem zrestartować komputer, ale to nie pomogło.")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Wiadomość pomyślnie dodana.", content: new OA\JsonContent(ref: "#/components/schemas/MessageFull")),
            new OA\Response(response: 401, description: "Błąd autoryzacji."),
            new OA\Response(response: 403, description: "Brak uprawnień do dodawania wiadomości w tym zgłoszeniu."),
            new OA\Response(response: 404, description: "Nie znaleziono zgłoszenia."),
            new OA\Response(response: 422, description: "Błąd walidacji (np. pusta treść).")
        ]
    )]
    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('addMessage', $ticket);

        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);

        $user = $request->user();

        $message = $ticket->messages()->create([
            'message' => $validatedData['body'],
            'sender_id' => $user->id,
        ]);

        // Rozgłoś zdarzenie do WebSocketów
        broadcast(new NewMessageSent($message->load('sender')))->toOthers();

        // Automatyczna zmiana statusu zgłoszenia po dodaniu wiadomości.
        $statusChanged = false;
        // 1. Jeśli zgłoszenie jest 'zamknięte', a wiadomość dodaje jego autor,
        //    zmieniamy status na 'w trakcie' (użytkownik ponownie otwiera zgłoszenie).
        if ($ticket->status === 'zamknięte' && $user->id === $ticket->user_id) {
            $ticket->status = 'w trakcie';
            $statusChanged = true;
        }

        // 2. Jeśli zgłoszenie jest 'nowe', a wiadomość dodaje pracownik IT/Admin,
        //    zmieniamy status na 'w trakcie' (rozpoczęcie obsługi).
        if ($ticket->status === 'nowe' && in_array($user->role, ['it', 'admin'])) {
            $ticket->status = 'w trakcie';
            $statusChanged = true;
        }

        if ($statusChanged) {
            $ticket->save();
        }

        return response()->json($message->load('sender'), 201);
    }
}
