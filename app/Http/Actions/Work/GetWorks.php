<?php

declare(strict_types=1);

namespace App\Http\Actions\Work;

use App\Models\Work;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetWorks
{
    public function handle(int $perPage): LengthAwarePaginator
    {
        return Work::query()
            ->latest()
            ->paginate(perPage: $perPage);
    }
}
