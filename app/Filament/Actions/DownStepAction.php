<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use BackedEnum;
use Closure;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

final class DownStepAction extends Action
{
    protected string|Closure|Htmlable|null|false|BackedEnum $icon = 'heroicon-o-arrow-down';

    protected function setUp(): void
    {
        $this->modalWidth = 'sm';
        $this->action($this->handle(...));
    }

    public static function make(?string $name = 'down'): static
    {
        return parent::make($name);
    }

    protected function handle(Model $record): void
    {
        $record->moveOrderDown();
        $record->save();
    }
}
