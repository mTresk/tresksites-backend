<?php

declare(strict_types=1);

namespace App\Actions\Service;

use App\Models\Service;
use Illuminate\Support\Collection;

final class GetServices
{
    public function handle(): Collection
    {
        return Service::query()->get();
    }
}
