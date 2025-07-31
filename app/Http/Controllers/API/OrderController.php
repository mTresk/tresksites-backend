<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Events\OrderReceived;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

final class OrderController
{
    public function create(OrderRequest $request)
    {
        $formData = $request->validated();

        $path = null;

        if ($request->hasFile(key: 'attachment')) {
            $file = $request->file(key: 'attachment');
            $path = $file->store(
                path: 'attachments',
                options: ['local']
            );
        }

        if ($formData) {
            $order = Order::create(
                attributes: [
                    ...$formData,
                    'attachment' => $path,
                ]
            );

            event(new OrderReceived(order: $order));
        }

        return response(
            content: 'Сообщение отправлено!',
            status: 200
        )->header(
            key: 'Content-Type',
            values: 'text/plain'
        );
    }
}
