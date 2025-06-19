<?php

namespace App\Filament\Resources\Services\Schemas;

use Exception;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    /**
     * @throws Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    SpatieMediaLibraryFileUpload::make('icon')
                        ->collection('services')
                        ->label('Иконка')
                        ->required(),
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->label('Заголовок'),
                    Textarea::make('description')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull()
                        ->label('Описание'),
                ]),
            ]);
    }
}
