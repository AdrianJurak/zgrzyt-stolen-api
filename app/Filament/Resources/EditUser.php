<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('changePassword')
                ->label('Zmień hasło')
                ->color('secondary')
                ->icon('heroicon-o-key')
                ->form([
                    TextInput::make('new_password')
                        ->password()
                        ->label('Nowe hasło')
                        ->required()
                        ->rule(Password::default()),
                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->label('Potwierdź nowe hasło')
                        ->required()
                        ->same('new_password'),
                ])
                ->action(function (User $record, array $data) {
                    $record->update([
                        'password' => Hash::make($data['new_password']),
                    ]);
                    $this->notify('success', 'Hasło zostało pomyślnie zaktualizowane.');
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
