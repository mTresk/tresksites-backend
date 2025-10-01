<?php

declare(strict_types=1);

namespace App\Http\Actions\Advantage;

use App\Models\Advantage;

final class GetAdvantages
{
    public function handle(): Advantage
    {
        return Advantage::query()->first();
    }
}
