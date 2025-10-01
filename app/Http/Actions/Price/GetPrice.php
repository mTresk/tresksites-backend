<?php

declare(strict_types=1);

namespace App\Http\Actions\Price;

use App\Models\Price;

final class GetPrice
{
    public function handle(): Price
    {
        return Price::query()->first();
    }
}
