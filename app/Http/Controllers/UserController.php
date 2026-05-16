<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    /**
     * Zwraca dane uwierzytelnionego użytkownika.
     */
    #[OA\Get(
        path: "/api/user",
        operationId: "getAuthenticatedUser",
        summary: "Pobierz dane zalogowanego użytkownika",
        description: "Zwraca dane użytkownika powiązanego z użytym tokenem API. Służy do weryfikacji tokena i pobrania podstawowych informacji (np. rola, nazwa). Jeśli token jest nieprawidłowy lub wygasł, serwer zwróci błąd 401 Unauthenticated.",
        tags: ["Użytkownicy"],
        security: [
            ["bearerAuth" => []]
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Dane zalogowanego użytkownika.",
                content: new OA\JsonContent(ref: "#/components/schemas/User")
            ),
            new OA\Response(response: 401, description: "Błąd autoryzacji (brak lub nieprawidłowy token).")
        ]
    )]
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(User::class, 'user', ['except' => ['activate', 'ban', 'getAuthenticatedUser']]);
    }

    public function getAuthenticatedUser(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    /**
     * Lista użytkowników. Dla roli user pokazuje tylko swoje konto, dla it/admin wszystkie.
     */
    public function index(Request $request): JsonResponse
    {
        $authUser = $request->user();

        if ($authUser->role === 'user') {
            $users = User::where('id', $authUser->id)->get();
        } else {
            $users = User::all();
        }

        return response()->json($users);
    }

    // /**
    //  * Tworzy nowego użytkownika.
    //  */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'login' => 'required|string|max:255|unique:users,login',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,it,admin',
        ]);

        $user = User::create(array_merge(
            $validated,
            ['password' => Hash::make($validated['password'])],
            ['active' => true]
        ));

        \App\Models\Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_user',
            'details' => 'Użytkownik '.auth()->user()->name.' utworzył nowe konto dla '.$user->name.' (ID: '.$user->id.').',
        ]);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'login' => 'sometimes|string|max:255|unique:users,login,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:user,it,admin',
            'active' => 'sometimes|boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }

    /**
     * Aktywuje użytkownika.
     */
    #[OA\Post(
        path: "/api/users/{user}/activate",
        operationId: "activateUser",
        summary: "Aktywacja konta użytkownika",
        description: "Aktywuje nieaktywne konto użytkownika. Dostępne tylko dla ról 'admin' lub 'it'.",
        tags: ["Użytkownicy"],
        security: [
            ["bearerAuth" => []]
        ],
        parameters: [
            new OA\Parameter(name: "user", in: "path", required: true, description: "ID użytkownika do aktywacji", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Konto pomyślnie aktywowane.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Konto użytkownika zostało pomyślnie aktywowane."),
                        new OA\Property(property: "user", ref: "#/components/schemas/User")
                    ]
                )
            ),
            new OA\Response(response: 403, description: "Brak uprawnień."),
            new OA\Response(response: 404, description: "Nie znaleziono użytkownika."),
            new OA\Response(response: 409, description: "Użytkownik jest już aktywny (Conflict).")
        ]
    )]
    public function activate(User $user): JsonResponse
    {
        $authUser = request()->user();
        \Log::info('UserController::activate input', ['auth_user_id' => $authUser->id, 'auth_user_role' => $authUser->role, 'target_user_id' => $user->id, 'target_user_role' => $user->role]);

        $this->authorize('changeStatus', $user);

        \Log::info('UserController::activate authorized', ['auth_user_id' => $authUser->id, 'target_user_id' => $user->id]);

        if ($user->active) {
            return response()->json([
                'message' => 'Konto użytkownika jest już aktywne.',
                'user' => $user,
            ], 409);
        }

        $user->active = true;
        $user->save();

        \App\Models\Log::create([
            'user_id' => $authUser->id,
            'action' => 'activate_user',
            'details' => 'Użytkownik '.$authUser->name.' aktywował konto '.$user->name.' (ID: '.$user->id.') przez API.',
        ]);

        return response()->json([
            'message' => 'Konto użytkownika ' . $user->email . ' zostało pomyślnie aktywowane.',
            'user' => $user
        ]);
    }

    /**
     * Banuje użytkownika.
     */
    #[OA\Post(
        path: "/api/users/{user}/ban",
        operationId: "banUser",
        summary: "Banowanie konta użytkownika",
        description: "Banuje konto użytkownika. Dostępne tylko dla ról 'admin' lub 'it'.",
        tags: ["Użytkownicy"],
        security: [
            ["bearerAuth" => []]
        ],
        parameters: [
            new OA\Parameter(name: "user", in: "path", required: true, description: "ID użytkownika do zbanowania", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Konto pomyślnie zbanowane.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Konto użytkownika zostało pomyślnie zbanowane."),
                        new OA\Property(property: "user", ref: "#/components/schemas/User")
                    ]
                )
            ),
            new OA\Response(response: 403, description: "Brak uprawnień."),
            new OA\Response(response: 404, description: "Nie znaleziono użytkownika."),
            new OA\Response(response: 409, description: "Użytkownik jest już zbanowany (Conflict).")
        ]
    )]
    public function ban(User $user): JsonResponse
    {
        $authUser = request()->user();
        \Log::info('UserController::ban input', ['auth_user_id' => $authUser->id, 'auth_user_role' => $authUser->role, 'target_user_id' => $user->id, 'target_user_role' => $user->role]);

        $this->authorize('changeStatus', $user);

        if ($user->banned_at) {
            return response()->json([
                'message' => 'Konto użytkownika jest już zbanowane.',
                'user' => $user,
            ], 409);
        }

        $user->banned_at = now();
        $user->ban= true;
        $user->save();

        \App\Models\Log::create([
            'user_id' => $authUser->id,
            'action' => 'ban_user',
            'details' => 'Użytkownik '.$authUser->name.' zbanował konto '.$user->name.' (ID: '.$user->id.') przez API.',
        ]);

        return response()->json([
            'message' => 'Konto użytkownika ' . $user->email . ' zostało pomyślnie zbanowane.',
            'user' => $user
        ]);
    }

    /**
     * Odblokowuje (unban) użytkownika.
     */
    #[OA\Post(
        path: "/api/users/{user}/unban",
        operationId: "unbanUser",
        summary: "Odblokowanie (unban) konta użytkownika",
        description: "Odblokowuje zbanowane konto użytkownika. Dostępne tylko dla ról 'admin' lub 'it'. Wymaga potwierdzenia hasłem osoby wykonującej akcję.",
        tags: ["Użytkownicy"],
        security: [
            ["bearerAuth" => []]
        ],
        parameters: [
            new OA\Parameter(name: "user", in: "path", required: true, description: "ID użytkownika do odbanowania", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Hasło użytkownika wykonującego operację w celu potwierdzenia.",
            content: new OA\JsonContent(
                required: ["password"],
                properties: [
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Konto pomyślnie odbanowane.",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Konto użytkownika zostało pomyślnie odbanowane."),
                        new OA\Property(property: "user", ref: "#/components/schemas/User")
                    ]
                )
            ),
            new OA\Response(response: 403, description: "Brak uprawnień lub nieprawidłowe hasło."),
            new OA\Response(response: 404, description: "Nie znaleziono użytkownika."),
            new OA\Response(response: 409, description: "Użytkownik nie jest zbanowany (Conflict)."),
            new OA\Response(response: 422, description: "Błąd walidacji (np. brak hasła).")
        ]
    )]
    public function unban(User $user): JsonResponse
    {
        $request = request();
        $authUser = $request->user();

        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($validated['password'], $authUser->password)) {
            return response()->json(['message' => 'Nieprawidłowe hasło.'], 403);
        }

        $this->authorize('unban', $user);

        if (!$user->banned_at) {
            return response()->json([
                'message' => 'Konto użytkownika nie jest zbanowane.',
                'user' => $user,
            ], 409);
        }

        $user->banned_at = null;
        $user->ban = false;

        $user->save();

        \App\Models\Log::create([
            'user_id' => $authUser->id,
            'action' => 'unban_user',
            'details' => 'Użytkownik '.$authUser->name.' odbanował konto '.$user->name.' (ID: '.$user->id.') przez API.',
        ]);

        return response()->json([
            'message' => 'Konto użytkownika ' . $user->email . ' zostało pomyślnie odbanowane.',
            'user' => $user
        ]);
    }
}
