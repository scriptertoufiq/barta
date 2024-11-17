<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Hidden;
Use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Full Name')
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->placeholder('example@example.com')
                    ->unique()
                    ->maxLength(255),
                TextInput::make('password')
                    ->required()
                    ->placeholder('Enter a password')
                    ->password(),
                TextInput::make('password_confirmation')
                    ->required()
                    ->password()
                    ->placeholder('Confirm password')
                    ->same('password')
                    ->label('Confirm Password'),
                Hidden::make('is_admin')
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('is_admin')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Admin' : 'User')
                    ->color(fn ($state) => $state ? 'success' : 'primary'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Disable')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
