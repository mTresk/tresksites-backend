<?php

declare(strict_types=1);

namespace App\Filament\Services;

use Exception;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class SEO
{
    /**
     * @throws Exception
     */
    public static function make(array $only = ['title', 'description']): Group
    {
        return Group::make(
            Arr::only([
                'title' => TextInput::make('title')
                    ->columnSpan(2)
                    ->helperText(function (?string $state): string {
                        return (string) Str::of((string) mb_strlen($state ?? ''))
                            ->append(' / ')
                            ->append(60 .' ')
                            ->append((string) Str::of('символов')->lower());
                    })
                    ->reactive()
                    ->label('SEO заголовок'),
                'description' => Textarea::make('description')
                    ->helperText(function (?string $state): string {
                        return (string) Str::of((string) mb_strlen($state ?? ''))
                            ->append(' / ')
                            ->append(160 .' ')
                            ->append((string) Str::of('символов')->lower());
                    })
                    ->reactive()
                    ->label('SEO описание')
                    ->columnSpan(2),
            ], $only)
        )
            ->afterStateHydrated(function (Group $component, ?Model $record) use ($only): void {
                $component->getChildSchema()->fill(
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
