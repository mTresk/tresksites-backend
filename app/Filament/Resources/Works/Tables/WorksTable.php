<?php

namespace App\Filament\Resources\Works\Tables;

use Exception;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class WorksTable
{
    /**
     * @throws Exception
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('featured')
                    ->label('Изображение'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Дата создания'),
                ToggleColumn::make('is_featured')
                    ->label('В подборке'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
