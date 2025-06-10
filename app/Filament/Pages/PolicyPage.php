<?php

namespace App\Filament\Pages;

use App\Models\Policy;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PolicyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Политика конфиденциальности';

    protected static ?string $title = 'Политика конфиденциальности';

    protected static ?string $slug = 'policy-page';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.policy-page';

    use InteractsWithForms;

    public ?array $data = [];

    public ?Policy $record = null;

    public function mount(): void
    {
        $record = Policy::first();

        if ($record) {
            $this->record = $record;
        } else {
            $this->record = Policy::create([
                'title' => '',
                'content' => '',
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
                    RichEditor::make('content')
                        ->label('Содержимое')
                        ->required(),
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
