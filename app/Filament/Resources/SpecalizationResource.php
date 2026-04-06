<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecalizationResource\Pages;
use App\Models\Specalization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class SpecalizationResource extends Resource
{
    protected static ?string $model = Specalization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('program_name_id')
                    ->relationship('programName', 'name')
                    ->required(),
                TextInput::make('code')
                    ->label('Kodi')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->label('Nomi')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Tavsif'),
                TextInput::make('price')
                    ->label('Summa (so‘m)')
                    ->numeric()
                    ->required(),
                Toggle::make('is_visible')
                    ->label('Ko‘rinadigan')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('programName.name')->label('Dastur')->sortable(),
                TextColumn::make('code')->label('Kodi')->sortable()->searchable(),
                TextColumn::make('name')->label('Nomi')->sortable()->searchable(),
                TextColumn::make('price')->label('Summa')->money('UZS')->sortable(),
                IconColumn::make('is_visible')->label('Holati')->boolean(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecalizations::route('/'),
            'create' => Pages\CreateSpecalization::route('/create'),
            'edit' => Pages\EditSpecalization::route('/{record}/edit'),
        ];
    }
}
