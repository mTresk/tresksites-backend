<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tags\Schemas;

use Exception;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class TagForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
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
            ]);
    }
}
