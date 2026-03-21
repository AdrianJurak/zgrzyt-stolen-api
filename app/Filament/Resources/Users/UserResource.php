<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use BackedEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('login')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'Użytkownik',
                        'it' => 'Pracownik IT',
                        'admin' => 'Administrator',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->label('Aktywny')
                    ->required()
                    ->default(false),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $page): bool => $page === 'create')
                    ->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('login')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'gray',
                        'it' => 'warning',
                        'admin' => 'success',
                    }),
                Tables\Columns\IconColumn::make('ban')
                    ->label('Ban')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-no-symbol')
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\TextColumn::make('banned_at')
                    ->label('Data banowania')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Aktywny')
                    ->afterStateUpdated(function ($record, $state) {
                        $actionText = $state ? 'aktywował' : 'dezaktywował';
                        \App\Models\Log::create([
                            'user_id' => auth()->id(),
                            'action' => 'Zmiana statusu konta',
                            'details' => 'Użytkownik '.auth()->user()->name." {$actionText} konto {$record->name} (ID: {$record->id}).",
                        ]);
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'Użytkownik',
                        'it' => 'Pracownik IT',
                        'admin' => 'Administrator',
                    ])
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('ban')
                    ->label('Zbanuj')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => is_null($record->banned_at))
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('Potwierdź hasłem')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data): void {
                        if (!Hash::check($data['password'], auth()->user()->password)) {
                            throw new \Filament\Exceptions\ValidationException(\Illuminate\Validation\ValidationException::withMessages(['password' => ['Nieprawidłowe hasło.']]));
                        }
                        $record->update(['banned_at' => now()]);
                        \App\Models\Log::create([
                            'user_id' => auth()->id(),
                            'action' => 'Zbanowano użytkownika',
                            'details' => 'Użytkownik '.auth()->user()->name." zbanował konto {$record->name} (ID: {$record->id}).",
                        ]);
                    }),
                Actions\Action::make('unban')
                    ->label('Odbanuj')
                    ->icon('heroicon-o-lock-open')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => !is_null($record->banned_at))
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('Potwierdź hasłem')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data): void {
                        $user = auth()->user();

                        if (!Hash::check($data['password'], $user->password)) {
                            throw new \Filament\Exceptions\ValidationException(\Illuminate\Validation\ValidationException::withMessages(['password' => ['Nieprawidłowe hasło.']]));
                        }
                        $record->update(['banned_at' => null]);
                        \App\Models\Log::create([
                            'user_id' => $user->id,
                            'action' => 'Odbanowano użytkownika',
                            'details' => "Użytkownik {$user->name} odbanował konto {$record->name} (ID: {$record->id}).",
                        ]);
                    }),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
