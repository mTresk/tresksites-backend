<?php

declare(strict_types=1);

namespace App\Actions\Work;

use App\Models\Work;
use Illuminate\Support\Collection;

final class GetOtherWorks
{
    public function handle(int|string $workId): Collection
    {
        return Work::query()
            ->where(
                column: 'id',
                operator: '!=',
                value: $workId
            )
            ->inRandomOrder()
            ->take(value: 3)
            ->get();
    }
}
