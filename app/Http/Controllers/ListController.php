<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ListController extends Controller
{
    /**
     * Zwraca listę aktywnych zgłoszeń (nowe i w trakcie).
     */
    #[OA\Get(
        path: "/api/active-tickets",
        operationId: "getActiveTicketsList",
        summary: "Lista aktywnych zgłoszeń (nowe i w trakcie)",
        description: "Zwraca paginowaną listę zgłoszeń ze statusem 'nowe' lub 'w trakcie'. Obsługuje wyszukiwanie po tytule i opisie.",
        tags: ["Zgłoszenia"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "per_page", in: "query", description: "Liczba wyników na stronę", required: false, schema: new OA\Schema(type: "integer", default: 15)),
            new OA\Parameter(name: "search", in: "query", description: "Wyszukiwana fraza (szuka w tytule i opisie)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista zgłoszeń pomyślnie pobrana."),
            new OA\Response(response: 401, description: "Brak autoryzacji."),
            new OA\Response(response: 403, description: "Brak uprawnień.")
        ]
    )]
    public function activeTickets(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        
        $query = Ticket::with(['user', 'assignedTo'])
            ->whereIn('status', ['nowe', 'w trakcie']);
            
        if ($request->filled('search')) {
            $searchTerm = '%' . mb_strtolower($request->search, 'UTF-8') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
            });
        }

        $tickets = $query->latest()->paginate($perPage);

        return response()->json($tickets);
    }

    /**
     * Zwraca listę nieprzypisanych zgłoszeń.
     */
    #[OA\Get(
        path: "/api/unassigned-tickets",
        operationId: "getUnassignedTicketsList",
        summary: "Lista nieprzypisanych zgłoszeń",
        description: "Zwraca paginowaną listę zgłoszeń, które nie zostały jeszcze przypisane do żadnego pracownika IT.",
        tags: ["Zgłoszenia"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "per_page", in: "query", description: "Liczba wyników na stronę", required: false, schema: new OA\Schema(type: "integer", default: 15)),
            new OA\Parameter(name: "search", in: "query", description: "Wyszukiwana fraza (szuka w tytule i opisie)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista zgłoszeń pomyślnie pobrana."),
            new OA\Response(response: 401, description: "Brak autoryzacji."),
            new OA\Response(response: 403, description: "Brak uprawnień.")
        ]
    )]
    public function unassignedTickets(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        
        $query = Ticket::with(['user'])
            ->whereNull('assigned_it_id');
            
        if ($request->filled('search')) {
            $searchTerm = '%' . mb_strtolower($request->search, 'UTF-8') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
            });
        }

        $tickets = $query->latest()->paginate($perPage);

        return response()->json($tickets);
    }

    /**
     * Zwraca listę zbanowanych użytkowników.
     */
    #[OA\Get(
        path: "/api/banned-users",
        operationId: "getBannedUsersList",
        summary: "Lista zbanowanych użytkowników",
        description: "Zwraca paginowaną listę zbanowanych użytkowników w systemie.",
        tags: ["Użytkownicy"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "per_page", in: "query", description: "Liczba wyników na stronę", required: false, schema: new OA\Schema(type: "integer", default: 15)),
            new OA\Parameter(name: "search", in: "query", description: "Wyszukiwana fraza (imię, login, email)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista pomyślnie pobrana."),
            new OA\Response(response: 401, description: "Brak autoryzacji.")
        ]
    )]
    public function bannedUsers(Request $request): JsonResponse
    {
        return response()->json($this->searchUsers($request, User::whereNotNull('banned_at')));
    }

    /**
     * Zwraca listę nieaktywnych użytkowników.
     */
    #[OA\Get(
        path: "/api/inactive-users",
        operationId: "getInactiveUsersList",
        summary: "Lista nieaktywnych użytkowników",
        description: "Zwraca paginowaną listę nieaktywnych użytkowników (np. oczekujących na zatwierdzenie).",
        tags: ["Użytkownicy"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "per_page", in: "query", description: "Liczba wyników na stronę", required: false, schema: new OA\Schema(type: "integer", default: 15)),
            new OA\Parameter(name: "search", in: "query", description: "Wyszukiwana fraza (imię, login, email)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista pomyślnie pobrana.")
        ]
    )]
    public function inactiveUsers(Request $request): JsonResponse
    {
        return response()->json($this->searchUsers($request, User::where('active', false)));
    }

    /**
     * Zwraca listę aktywnych (niezbanowanych) użytkowników.
     */
    #[OA\Get(
        path: "/api/active-users",
        operationId: "getActiveUsersList",
        summary: "Lista aktywnych użytkowników",
        description: "Zwraca paginowaną listę w pełni aktywnych użytkowników.",
        tags: ["Użytkownicy"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "per_page", in: "query", description: "Liczba wyników na stronę", required: false, schema: new OA\Schema(type: "integer", default: 15)),
            new OA\Parameter(name: "search", in: "query", description: "Wyszukiwana fraza (imię, login, email)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista pomyślnie pobrana.")
        ]
    )]
    public function activeUsers(Request $request): JsonResponse
    {
        return response()->json($this->searchUsers($request, User::where('active', true)->whereNull('banned_at')));
    }

    /**
     * Metoda pomocnicza do wyszukiwania po wspólnych polach użytkowników.
     */
    private function searchUsers(Request $request, $query)
    {
        $perPage = $request->get('per_page', 15);
        
        if ($request->filled('search')) {
            $searchTerm = '%' . mb_strtolower($request->search, 'UTF-8') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm])
                  ->orWhereRaw('LOWER(login) LIKE ?', [$searchTerm]);
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
