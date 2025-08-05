<?php

declare(strict_types=1);

namespace App\Filament\Resources\Works\Tables;

use App\Filament\Actions\DownStepAction;
use App\Filament\Actions\UpStepAction;
use Exception;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

final class WorksTable
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
            ->defaultSort('order_column')
            ->filters([
                //
            ])
            ->recordActions([
                DownStepAction::make(),
                UpStepAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
