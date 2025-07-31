<?php

declare(strict_types=1);

namespace App\Filament\Resources\Works\Pages;

use App\Filament\Resources\Works\WorkResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateWork extends CreateRecord
{
    protected static string $resource = WorkResource::class;
}
