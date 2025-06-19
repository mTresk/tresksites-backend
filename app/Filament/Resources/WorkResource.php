<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkResource\Pages\CreateWork;
use App\Filament\Resources\WorkResource\Pages\EditWork;
use App\Filament\Resources\WorkResource\Pages\ListWorks;
use App\Filament\Services\SEO;
use App\Models\Work;
use BackedEnum;
use Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Работы';

    protected static ?string $pluralModelLabel = 'Работы';

    protected static ?string $navigationLabel = 'Работы';

    protected static ?int $navigationSort = 1;

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                                ->live(true)
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
                            Select::make('tag_id')
                                ->multiple()
                                ->preload()
                                ->createOptionForm([
                                    Section::make()
                                        ->schema([
                                            TextInput::make('name')
                                                ->live(true)->afterStateUpdated(fn (Set $set, ?string $state) => $set(
                                                    'slug',
                                                    Str::slug($state)
                                                ))
                                                ->unique('tags', 'name', null, true)
                                                ->required()
                                                ->maxLength(50)
                                                ->label('Название'),

                                            TextInput::make('slug')
                                                ->unique('tags', 'slug', null, true)
                                                ->maxLength(155)
                                                ->label('Слаг'),
                                        ]),
                                ])
                                ->searchable()
                                ->relationship('tags', 'name')
                                ->label('Теги'),
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
                            Block::make('block')
                                ->schema([
                                    RichEditor::make('html')
                                        ->required()
                                        ->label('Текст'),
                                    Hidden::make('gallery_id')
                                        ->default(fn () => Str::random(12)),
                                    SpatieMediaLibraryFileUpload::make('images')
                                        ->label('Изображение')
                                        ->collection('works')
                                        ->multiple()
                                        ->required()
                                        ->downloadable()
                                        ->customProperties(fn (Get $get): array => [
                                            'gallery_id' => $get('gallery_id'),
                                        ])
                                        ->filterMediaUsing(
                                            fn (Collection $media, Get $get): Collection => $media->where(
                                                'custom_properties.gallery_id',
                                                $get('gallery_id')
                                            ),
                                        ),
                                ])
                                ->label('Текст + изображение'),
                            Block::make('text')
                                ->schema([
                                    RichEditor::make('html')
                                        ->required()
                                        ->label('Текст'),
                                ])
                                ->label('Текст'),
                        ])
                        ->hiddenLabel()
                        ->addActionLabel('Добавить блок'),
                ])->columnSpan(2),
                Section::make('SEO')
                    ->schema([
                        SEO::make(),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListWorks::route('/'),
            'create' => CreateWork::route('/create'),
            'edit' => EditWork::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}
