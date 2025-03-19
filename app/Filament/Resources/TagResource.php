<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $modelLabel = 'Теги';
    protected static ?string $pluralModelLabel = 'Теги';
    protected static ?string $navigationLabel = 'Теги';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->live(true)->afterStateUpdated(fn(Set $set, ?string $state) => $set(
                                'slug',
                                Str::slug($state)
                            ))
                            ->unique('tags', 'name', null, 'id')
                            ->required()
                            ->maxLength(50)
                            ->label('Название'),

                        TextInput::make('slug')
                            ->unique('tags', 'slug', null, 'id')
                            ->maxLength(155)
                            ->label('Слаг'),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Слаг'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
