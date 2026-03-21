<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;


    /**
     * Określa, czy użytkownik może wyświetlić listę zgłoszeń.
     * Logika filtrowania (swoje vs wszystkie) jest już w kontrolerze,
     * więc tutaj po prostu zezwalamy na dostęp do samego endpointu.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Określa, czy użytkownik może wyświetlić konkretne zgłoszenie.
     * Użytkownik 'user' może zobaczyć tylko swoje zgłoszenie, a 'admin' i 'it' mogą zobaczyć wszystkie.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, ['admin', 'it']) || $user->id === $ticket->user_id;
    }

    /**
     * Określa, czy użytkownik może tworzyć zgłoszenia.
     * Zgodnie z matrycą, każdy zalogowany użytkownik może to zrobić.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Określa, czy użytkownik może zaktualizować zgłoszenie.
     * Uprawnienia mają tylko role 'admin' i 'it'.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, ['admin', 'it']);
    }

    /**
     * Określa, czy użytkownik może usunąć zgłoszenie.
     * Uprawnienia mają tylko role 'admin' i 'it'.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, ['admin', 'it']);
    }

    /**
     * Określa, czy użytkownik może dodać wiadomość do zgłoszenia.
     * Zwykły użytkownik może pisać tylko w swoich zgłoszeniach, a 'admin' i 'it' we wszystkich.
     */
    public function addMessage(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, ['admin', 'it']) || $user->id === $ticket->user_id;
    }
}
