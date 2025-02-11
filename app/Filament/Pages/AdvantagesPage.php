<?php

namespace App\Filament\Pages;

use App\Models\Advantage;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AdvantagesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-fire';
    protected static ?string $navigationLabel = 'Преимущества';
    protected static ?string $title = 'Преимущества';
    protected static ?string $slug = 'advantages-page';
    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.advantages-page';

    use InteractsWithForms;

    public ?array $data = [];

    public ?Advantage $record = null;

    public function mount(): void
    {
        $record = Advantage::first();

        if ($record) {
            $this->record = $record;
        } else {
            $this->record = Advantage::create([
                'block' => [],
            ]);
        }

        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        ->columns(2)
                        ->maxItems(4),
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
