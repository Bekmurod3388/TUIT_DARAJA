<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecalizationResource\Pages;
use App\Models\Specalization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SpecalizationResource extends Resource
{
    protected static ?string $model = Specalization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->label('Raqam')
                    ->maxLength(10)
                    ->required(),
                TextInput::make('name')
                    ->label('Nomi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Raqam')->sortable()->searchable(),
                TextColumn::make('name')->label('Nomi')->sortable()->searchable(),
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
