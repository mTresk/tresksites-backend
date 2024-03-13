<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkResource\Pages;
use App\Filament\Services\SEO;
use App\Models\Work;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $modelLabel = 'Работы';
    protected static ?string $pluralModelLabel = 'Работы';
    protected static ?string $navigationLabel = 'Работы';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Контент')->schema([
                    Section::make()
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('featured')
                                ->collection('featured')
                                ->label('Основное изображение')
                                ->required()
                                ->downloadable(),
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                    if (($get('slug') ?? '') !== Str::slug($old)) {
                                        return;
                                    }

                                    $set('slug', Str::slug($state));
                                })
                                ->label('Заголовок'),
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->label('Слаг'),
                            TextInput::make('label')
                                ->maxLength(255)
                                ->label('Лейбл'),
                            TextInput::make('url')
                                ->maxLength(255)
                                ->label('Ссылка'),
                            Toggle::make('is_featured')
                                ->required()
                                ->label('В подборке'),
                            RichEditor::make('list')
                                ->maxLength(65535)
                                ->columnSpanFull()
                                ->label('Список'),
                        ]),
                    Builder::make('content')
                        ->blocks([
                            Builder\Block::make('block')
                                ->schema([
                                    RichEditor::make('html')
                                        ->required()
                                        ->label('Текст'),
                                    Hidden::make('gallery_id')
                                        ->default(fn() => Str::random(12)),
                                    SpatieMediaLibraryFileUpload::make('images')
                                        ->label('Изображение')
                                        ->collection('works')
                                        ->multiple()
                                        ->required()
                                        ->downloadable()
                                        ->customProperties(fn(Get $get): array => [
                                            'gallery_id' => $get('gallery_id'),
                                        ])
                                        ->filterMediaUsing(
                                            fn(Collection $media, Get $get): Collection => $media->where(
                                                'custom_properties.gallery_id',
                                                $get('gallery_id')
                                            ),
                                        ),
                                ])
                                ->label('Текст + изображение'),
                            Builder\Block::make('text')
                                ->schema([
                                    RichEditor::make('html')
                                        ->required()
                                        ->label('Текст'),
                                ])
                                ->label('Текст')
                        ])
                        ->hiddenLabel()
                        ->addActionLabel('Добавить блок'),
                ])->columnSpan(2),
                Section::make('SEO')
                    ->schema([
                        SEO::make()])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('featured')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Дата создания'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListWorks::route('/'),
            'create' => Pages\CreateWork::route('/create'),
            'edit' => Pages\EditWork::route('/{record}/edit'),
        ];
    }
}
