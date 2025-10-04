<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Order;

final class CreateOrder
{
    public function handle(array $attributes, ?string $path): Order
    {
        return Order::create(
            attributes: [
                ...$attributes,
                'attachment' => $path,
            ]
        );
    }
}
