<?php

declare(strict_types=1);

namespace App\Http\Actions\Work;

use App\Models\Work;
use Illuminate\Support\Collection;

final class GetFeaturedWorks
{
    public function handle(): Collection
    {
        return Work::query()
            ->where(
                column: 'is_featured',
                operator: '=',
                value: true)
            ->orderBy('order_column')
            ->get();
    }
}
