<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class SessionController extends Controller
{
    /**
     * Wyloguj użytkownika i wyczyść sesję
     */
    #[OA\Post(
        path: "/logout",
        operationId: "logoutSession",
        summary: "Wylogowanie użytkownika (sesja webowa)",
        description: "Kończy sesję użytkownika w aplikacji webowej (unieważnia sesję).",
        tags: ["Sesja"],
        responses: [
            new OA\Response(response: 200, description: "Pomyślnie wylogowano"),
            new OA\Response(response: 401, description: "Błąd autoryzacji (użytkownik niezalogowany)"),
        ]
    )]
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Jeśli to żądanie AJAX, zwróć JSON
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Wylogowano pomyślnie',
                'status' => 'success'
            ]);
        }

        return redirect('/admin/login')->with('success', 'Wylogowano pomyślnie');
    }

    /**
     * Wyczyść token i resetuj sesję
     */
    #[OA\Post(
        path: "/reset-session",
        operationId: "resetSession",
        summary: "Resetowanie sesji",
        description: "Wymusza wyczyszczenie całej sesji i tokenów po stronie serwera.",
        tags: ["Sesja"],
        responses: [
            new OA\Response(response: 200, description: "Sesja wyczyszczona"),
        ]
    )]
    public function resetSession(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Sesja wyczyszczona',
            'status' => 'success'
        ]);
    }

    /**
     * Sprawdź status autoryzacji
     */
    #[OA\Get(
        path: "/auth-status",
        operationId: "checkAuthStatus",
        summary: "Sprawdzenie statusu autoryzacji",
        description: "Zwraca informację, czy użytkownik jest aktualnie zalogowany, wraz z jego podstawowymi danymi.",
        tags: ["Sesja"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Zwraca status autoryzacji i dane użytkownika",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "authenticated", type: "boolean"),
                    ]
                )
            ),
        ]
    )]
    public function checkAuth(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }
}
