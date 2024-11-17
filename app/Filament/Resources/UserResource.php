<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                TextColumn::make('email')
                    ->wrap()  // Enable text wrapping for this column
                    ->limit(30),
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
                SelectFilter::make('is_admin')
                    ->label('User Type')
                    ->options([
                        '1' => 'Admin',
                        '0' => 'User',
                    ]),
                SelectFilter::make('status')
                    ->label('User Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Disabled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Active')
                    ->badge()
                    ->requiresConfirmation()
                    ->modalHeading('Are you sure?')
                    ->modalSubheading('Do you really want to proceed with this action?')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->status = true;
                        $record->save();
                        Notification::make()
                            ->body('User Status update successfully completed.')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn (User $record): bool => $record->status),
                Action::make('Disable')
                    ->color('danger')
                    ->badge()
                    ->requiresConfirmation()
                    ->modalHeading('Are you sure?')
                    ->modalSubheading('Do you really want to proceed with this action?')
                    ->action(function (User $record) {
                        $record->status = false;
                        $record->save();
                        Notification::make()
                            ->body('User Status update successfully completed.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (User $record): bool => $record->status),
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
