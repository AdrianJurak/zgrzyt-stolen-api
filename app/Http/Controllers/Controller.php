<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "ZGRZYT API",
    description: "Dokumentacja API dla systemu Zgłoszeń i Rejestru Zdarzeń Technicznych (ZGRZYT). Jest to webowa aplikacja do zgłaszania, obsługi i monitorowania błędów w systemach informatycznych."
)]
#[OA\Tag(name: "Autoryzacja", description: "Endpointy do rejestracji i wylogowywania z API tokenowego.")]
#[OA\Tag(name: "Sesja", description: "Operacje związane z sesją (logowanie, status, wylogowanie) dla panelu webowego i API.")]
#[OA\Tag(name: "Zgłoszenia", description: "Zarządzanie zgłoszeniami (tickets).")]
#[OA\Tag(name: "Wiadomości", description: "Komunikacja w ramach zgłoszeń.")]
#[OA\Schema(
    schema: "User",
    title: "User",
    description: "Model użytkownika",
    properties: [
        new OA\Property(property: "id", type: "integer", readOnly: true, example: 1),
        new OA\Property(property: "name", type: "string", example: "Jan Kowalski"),
        new OA\Property(property: "login", type: "string", example: "jkowalski"),
        new OA\Property(property: "email", type: "string", format: "email", example: "j.kowalski@example.com"),
        new OA\Property(property: "role", type: "string", enum: ["user", "it", "admin"], example: "user"),
        new OA\Property(property: "active", type: "boolean", description: "Status aktywności konta.", example: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time", readOnly: true),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", readOnly: true),
    ]
)]
#[OA\Schema(
    schema: "Ticket",
    title: "Ticket",
    description: "Model zgłoszenia",
    properties: [
        new OA\Property(property: "id", type: "integer", readOnly: true, example: 1),
        new OA\Property(property: "title", type: "string", example: "Błąd logowania"),
        new OA\Property(property: "description", type: "string", example: "Nie mogę się zalogować do systemu X."),
        new OA\Property(property: "status", type: "string", enum: ["nowe", "w trakcie", "zamknięte"], example: "nowe"),
        new OA\Property(property: "priority", type: "string", enum: ["niski", "średni", "wysoki"], example: "średni"),
        new OA\Property(property: "user_id", type: "integer", example: 1),
        new OA\Property(property: "assigned_it_id", type: "integer", nullable: true, example: 2),
        new OA\Property(property: "created_at", type: "string", format: "date-time", readOnly: true),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", readOnly: true),
    ]
)]
#[OA\Schema(
    schema: "Message",
    title: "Message",
    description: "Model wiadomości w zgłoszeniu",
    properties: [
        new OA\Property(property: "id", type: "integer", readOnly: true, example: 1),
        new OA\Property(property: "body", type: "string", example: "Proszę o więcej szczegółów."),
        new OA\Property(property: "ticket_id", type: "integer", example: 1),
        new OA\Property(property: "sender_id", type: "integer", example: 2),
        new OA\Property(property: "created_at", type: "string", format: "date-time", readOnly: true),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", readOnly: true),
    ]
)]
#[OA\Schema(
    schema: "TicketFull",
    title: "TicketFull",
    allOf: [
        new OA\Schema(ref: "#/components/schemas/Ticket"),
        new OA\Schema(properties: [
            new OA\Property(property: "user", ref: "#/components/schemas/User"),
            new OA\Property(property: "assignedTo", ref: "#/components/schemas/User", nullable: true),
            new OA\Property(property: "messages", type: "array", items: new OA\Items(ref: "#/components/schemas/MessageFull")),
        ])
    ]
)]
#[OA\Schema(
    schema: "MessageFull",
    title: "MessageFull",
    allOf: [
        new OA\Schema(ref: "#/components/schemas/Message"),
        new OA\Schema(properties: [
            new OA\Property(property: "sender", ref: "#/components/schemas/User"),
        ])
    ]
)]
#[OA\Components(
    securitySchemes: [
        new OA\SecurityScheme(
            securityScheme: "bearerAuth",
            type: "http",
            scheme: "bearer",
            bearerFormat: "JWT"
        )
    ]
)]
#[OA\SecurityRequirement(name: "bearerAuth")]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
