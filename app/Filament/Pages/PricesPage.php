<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Price;
use BackedEnum;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

final class PricesPage extends Page
{
    public ?array $data = [];

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $navigationLabel = 'Цены';

    protected static ?string $title = 'Цены';

    protected static ?string $slug = 'prices-page';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.custom-page';

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());
    }

    /**
     * @throws Exception
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->required(),
                    Textarea::make('description')
                        ->label('Описание'),
                    Repeater::make('block')
                        ->schema([
                            TextInput::make('service')
                                ->label('Услуга'),
                            TextInput::make('price')
                                ->label('Цена'),
                        ])
                        ->label('Цены')
                        ->addActionLabel('Добавить позицию')
                        ->columns(),
                ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();

        if (! $record) {
            $record = new Price();
        }

        $record->fill($data);
        $record->save();

        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    public function getRecord(): ?Price
    {
        return Price::query()->first();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
}
