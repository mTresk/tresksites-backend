<?php

namespace App\Filament\Pages;

use App\Models\Contact;
use BackedEnum;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ContactsPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'Контакты';

    protected static ?string $title = 'Контакты';

    protected static ?string $slug = 'contacts-page';

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
                                ->label('Содержимое'),
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
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();

        if (! $record) {
            $record = new Contact();
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

    public function getRecord(): ?Contact
    {
        return Contact::query()->first();
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
