<?php

declare(strict_types=1);

namespace App\Filament\Resources\Orders\Schemas;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

final class OrderForm
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
                        ->required()
                        ->maxLength(255)
                        ->label('Имя'),
                    TextInput::make('phone')
                        ->required()
                        ->maxLength(255)
                        ->label('Телефон'),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    Textarea::make('message')
                        ->label('Сообщение')
                        ->rows(5),
                    FileUpload::make('attachment')
                        ->disk('local')
                        ->directory('attachments')
                        ->label('Файл'),
                    Actions::make([
                        Action::make('download')
                            ->label('Скачать')
                            ->action(fn ($record) => Storage::disk('local')->download($record->attachment))
                            ->button(),
                    ])->hidden(fn ($record) => ! $record->attachment),
                ]),
            ]);
    }
}
