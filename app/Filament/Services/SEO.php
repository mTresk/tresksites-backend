<?php

namespace App\Filament\Services;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SEO
{
    public static function make(array $only = ['title', 'description']): Group
    {
        return Group::make(
            Arr::only([
                'title' => TextInput::make('title')
                    ->columnSpan(2)
                    ->helperText(function (?string $state): string {
                        return Str::of((string) strlen($state ?? ''))
                            ->append(' / ')
                            ->append(60 .' ')
                            ->append(Str::of('символов')->lower());
                    })
                    ->reactive()
                    ->label('SEO заголовок'),
                'description' => Textarea::make('description')
                    ->helperText(function (?string $state): string {
                        return Str::of((string) strlen($state ?? ''))
                            ->append(' / ')
                            ->append(160 .' ')
                            ->append(Str::of('символов')->lower());
                    })
                    ->reactive()
                    ->label('SEO описание')
                    ->columnSpan(2),
            ], $only)
        )
            ->afterStateHydrated(function (Group $component, ?Model $record) use ($only): void {
                $component->getChildComponentContainer()->fill(
                    $record?->seo?->only($only) ?: []
                );
            })
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                $state = collect($state)->only($only)->map(fn ($value) => $value ?: null)->all();

                if ($record->seo && $record->seo->exists) {
                    $record->seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }
}
