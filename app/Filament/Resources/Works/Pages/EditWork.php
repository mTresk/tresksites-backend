<?php

namespace App\Filament\Resources\Works\Pages;

use App\Filament\Resources\Works\WorkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWork extends EditRecord
{
    protected static string $resource = WorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
