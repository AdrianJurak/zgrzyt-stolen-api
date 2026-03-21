<?php

namespace App\Filament\Resources\Logs;

use App\Filament\Resources\Logs\Pages;
use App\Models\Log;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogResource extends Resource
{
    protected static ?string $model = Log::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('user.name')->label('Użytkownik'),
                Forms\Components\TextInput::make('action')->label('Akcja'),
                Forms\Components\Textarea::make('details')->label('Szczegóły')->columnSpanFull(),
                Forms\Components\Textarea::make('data')->label('Json')->columnSpanFull(),
                Forms\Components\DateTimePicker::make('created_at')->label('Data'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Użytkownik')->searchable(),
                Tables\Columns\TextColumn::make('action')->searchable(),
                Tables\Columns\TextColumn::make('details')->limit(50),
                Tables\Columns\TextColumn::make('data')->label('Dane')->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->label('Data'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListLogs::route('/'),
        ];
    }    
}
