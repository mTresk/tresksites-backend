<?php

namespace App\Filament\Pages;

use App\Models\Contact;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ContactsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Контакты';
    protected static ?string $title = 'Контакты';
    protected static ?string $slug = 'contacts-page';
    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.contacts-page';

    use InteractsWithForms;

    public ?array $data = [];

    public ?Contact $record = null;

    public function mount(): void
    {
        $record = Contact::first();

        if ($record) {
            $this->record = $record;
        } else {
            $this->record = Contact::create([
                'name' => '',
                'text' => '',
                'email' => '',
                'telegram' => '',
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
                    TextInput::make('name')
                        ->label('Имя'),
                    TextInput::make('inn')
                        ->label('ИНН'),
                    TextInput::make('email')
                        ->label('Email'),
                    TextInput::make('telegram')
                        ->label('Telegram'),
                    Repeater::make('block')
                        ->schema([
                            RichEditor::make('content')
                                ->label('Содержимое')
                        ])
                        ->label('Информация')
                        ->addActionLabel('Добавить содержимое'),
                    SpatieMediaLibraryFileUpload::make('brief')
                        ->collection('files')
                        ->label('Бриф')
                        ->required()
                        ->downloadable(),
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
