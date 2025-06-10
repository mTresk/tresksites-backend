<?php

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

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'local');
        }

        if ($formData) {
            $order = Order::create([
                ...$formData,
                'attachment' => $path,
            ]);

            event(new OrderReceived($order));
        }

        return response('Сообщение отправлено!', 200)
            ->header('Content-Type', 'text/plain');
    }
}
