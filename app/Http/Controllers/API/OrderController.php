<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Events\OrderReceived;
use App\Http\Actions\Order\CreateOrder;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Response;

final class OrderController
{
    public function create(OrderRequest $request, CreateOrder $createOrder): Response
    {
        $attributes = $request->validated();

        $path = '';

        if ($request->hasFile(key: 'attachment')) {
            $file = $request->file(key: 'attachment');

            $path = $file->store(
                path: 'attachments',
                options: ['local']
            );
        }

        $order = $createOrder->handle(
            attributes: $attributes,
            path: $path
        );

        event(new OrderReceived(order: $order));

        return response(
            content: 'Сообщение отправлено!',
            status: 200
        )->header(
            key: 'Content-Type',
            values: 'text/plain'
        );
    }
}
