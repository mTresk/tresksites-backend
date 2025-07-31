<?php

declare(strict_types=1);

namespace App\Filament\Resources\Works;

use App\Filament\Resources\Works\Pages\CreateWork;
use App\Filament\Resources\Works\Pages\EditWork;
use App\Filament\Resources\Works\Pages\ListWorks;
use App\Filament\Resources\Works\Schemas\WorkForm;
use App\Filament\Resources\Works\Tables\WorksTable;
use App\Models\Work;
use BackedEnum;
use Exception;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $modelLabel = 'Работы';

    protected static ?string $pluralModelLabel = 'Работы';

    protected static ?string $navigationLabel = 'Работы';

    protected static ?int $navigationSort = 1;

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return WorkForm::configure($schema);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return WorksTable::configure($table);
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

    public static function getNavigationBadge(): string
    {
        return (string) self::getModel()::count();
    }
}
