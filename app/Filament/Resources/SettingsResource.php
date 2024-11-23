<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Filament\Resources\SettingsResource\RelationManagers;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        TextInput::make('system_name')
                            ->label('System Names')
                            ->required()
                            ->placeholder('Enter System Name'),
                    ]),
                TextInput::make('system_title')
                    ->label('System Title')
                    ->required()
                    ->placeholder('Enter System Title'),
                TextInput::make('system_email')
                    ->label('System Email')
                    ->required()
                    ->email()
                    ->placeholder('Enter System Email'),
                TextInput::make('system_phone')
                    ->label('System Phone')
                    ->placeholder('Enter System Phone'),
                TextInput::make('system_Fax')
                    ->label('System Fax')
                    ->placeholder('Enter System Fax'),
                TextInput::make('system_address')
                    ->label('System Address')
                    ->placeholder('Enter System Address'),
                Select::make('system_currency')
                    ->options([
                        'bdt' => 'BDT',
                        'usd' => 'USD',
                        'inr' => 'INR',
                    ])
                    ->label('System Currency')
                    ->searchable()
                    ->placeholder('Select System Currency'),
                Select::make('system_lang')
                    ->options([
                        'bn' => 'BN',
                        'en' => 'ENG',
                    ])
                    ->label('System Language')
                    ->searchable()
                    ->placeholder('Select System Language'),
                Select::make('system_public_signup')
                    ->options([
                        'enable' => 'Enable',
                        'disable' => 'Disable',
                    ])
                    ->label('System Public Signup')
                    ->searchable()
                    ->placeholder('Select System Public Signup'),
                TextInput::make('system_header')
                    ->label('System Header')
                    ->placeholder('Enter System Header'),
                TextInput::make('system_header_url')
                    ->label('System Header Url')
                    ->url()
                    ->placeholder('Enter System Header Url'),
                TextInput::make('system_footer')
                    ->label('System Footer')
                    ->placeholder('Enter System Footer'),
                TextInput::make('system_footer_url')
                    ->label('System Footer Url')
                    ->url()
                    ->placeholder('Enter System Footer Url'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSettings::route('/create'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }
}
