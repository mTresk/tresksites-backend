<?php

declare(strict_types=1);

namespace App\Actions\Policy;

use App\Models\Policy;

final class GetPolicy
{
    public function handle(): Policy
    {
        return Policy::query()->first();
    }
}
