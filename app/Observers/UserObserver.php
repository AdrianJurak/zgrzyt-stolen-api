<?php

namespace App\Observers;

use App\Models\User;
use App\Services\LogService;

class UserObserver
{
    public function created(User $user): void
    {
        LogService::logCreate($user, null, 'Utworzono nowego użytkownika');
    }

    public function updated(User $user): void
    {
        if ($user->isDirty()) {
            LogService::logUpdate($user, $user->getDirty(), null, 'Zaktualizowano użytkownika');
        }
    }

    public function deleted(User $user): void
    {
        LogService::logDelete($user, null, 'Usunięto użytkownika');
    }
}
