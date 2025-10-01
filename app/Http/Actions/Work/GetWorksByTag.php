<?php

declare(strict_types=1);

namespace App\Http\Actions\Work;

use App\Models\Work;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetWorksByTag
{
    public function handle(string $slug, int $perPage): LengthAwarePaginator
    {
        return Work::query()
            ->whereRelation(
                relation: 'tags',
                column: 'slug',
                operator: '=',
                value: $slug
            )
            ->latest()
            ->paginate(perPage: $perPage);
    }
}
