<?php

declare(strict_types=1);

namespace App\Actions\Work;

use App\Models\Work;
use Illuminate\Support\Collection;

final class GetAllWorks
{
    public function handle(): Collection
    {
        return Work::query()->get();
    }
}
