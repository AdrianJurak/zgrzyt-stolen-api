<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('rola')
                    ->required()
                    ->default('user'),
                Toggle::make('banned')
                    ->required(),
                TextInput::make('login')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options(['user' => 'User', 'it' => 'It', 'admin' => 'Admin'])
                    ->default('user')
                    ->required(),
                Toggle::make('active')
                    ->required(),
                DateTimePicker::make('data_banned'),
                DateTimePicker::make('active_time'),
            ]);
    }
}
