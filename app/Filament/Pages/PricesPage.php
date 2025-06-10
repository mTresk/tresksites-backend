<?php

namespace App\Filament\Pages;

use App\Models\Price;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PricesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Цены';

    protected static ?string $title = 'Цены';

    protected static ?string $slug = 'prices-page';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.prices-page';

    use InteractsWithForms;

    public ?array $data = [];

    public ?Price $record = null;

    public function mount(): void
    {
        $record = Price::first();

        if ($record) {
            $this->record = $record;
        } else {
            $this->record = Price::create([
                'title' => '',
                'description' => '',
                'block' => '',
            ]);
        }

        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        ->columns(2),
                ]),
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    public function save(): void
    {
        $this->record->update($this->form->getState());
        $this->form->model($this->record)->saveRelationships();

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
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
