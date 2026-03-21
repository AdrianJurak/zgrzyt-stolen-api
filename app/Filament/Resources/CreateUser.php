<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record;
        \App\Models\Log::create([
            'user_id' => auth()->id(),
            'action' => 'create_user',
            'details' => 'Użytkownik '.auth()->user()->name.' utworzył nowe konto dla '.$user->name.' (ID: '.$user->id.') przez panel Filament.',
        ]);
    }
}
