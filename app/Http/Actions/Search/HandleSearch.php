<?php

declare(strict_types=1);

namespace App\Http\Actions\Search;

use App\Models\Work;
use Illuminate\Support\Collection;

final class HandleSearch
{
    public function handle(string $query): Collection
    {
        return Work::search(query: $query)->get();
    }
}
