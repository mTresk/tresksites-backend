<?php

namespace App\Filament\Pages;

use App\Models\Advantage;
use BackedEnum;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AdvantagesPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;

    protected static ?string $navigationLabel = 'Преимущества';

    protected static ?string $title = 'Преимущества';

    protected static ?string $slug = 'advantages-page';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.custom-page';

    public ?array $data = [];

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
                    Repeater::make('block')
                        ->schema([
                            TextInput::make('title')
                                ->label('Заголовок'),
                            TextInput::make('description')
                                ->label('Описание'),
                        ])
                        ->label('Преимущества')
                        ->addActionLabel('Добавить позицию')
                        ->columns()
                        ->maxItems(4),
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
            $record = new Advantage();
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

    public function getRecord(): ?Advantage
    {
        return Advantage::query()->first();
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
