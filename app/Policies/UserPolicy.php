<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Wykonuje sprawdzenie uprawnień przed innymi metodami.
     * Admin ma dostęp do wszystkiego.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    /**
     * Określa, czy użytkownik może wyświetlić listę użytkowników.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['it', 'admin']);
    }

    /**
     * Określa, czy użytkownik może tworzyć nowych użytkowników.
     */
    public function create(User $user): bool
    {
        // IT może tworzyć użytkowników (admin obsłużony w `before`).
        return $user->role === 'it';
    }

    /**
     * Określa, czy użytkownik może aktualizować innego użytkownika.
     */
    public function update(User $user, User $model): bool
    {
        // IT może edytować użytkowników (admin obsłużony w `before`).
        return $user->role === 'it';
    }

    /**
     * Określa, czy użytkownik może usunąć innego użytkownika.
     */
    public function delete(User $user, User $model): bool
    {
        // Tylko admin może usuwać (obsłużone w `before`).
        return false;
    }

    /**
     * Określa, czy użytkownik może aktywować lub zbanować konto.
     */
    public function changeStatus(User $user, User $model): bool
    {
        return in_array($user->role, ['it', 'admin']);
    }

    /**
     * Określa, czy użytkownik może aktywować konto.
     */
    public function activate(User $user, User $model): bool
    {
        return in_array($user->role, ['it', 'admin']);
    }

    /**
     * Określa, czy użytkownik może zbanować konto.
     */
    public function ban(User $user, User $model): bool
    {
        return in_array($user->role, ['it', 'admin']);
    }

    /**
     * Określa, czy użytkownik może odbanować konto.
     */
    public function unban(User $user, User $model): bool
    {
        return in_array($user->role, ['it', 'admin']);
    }
}
