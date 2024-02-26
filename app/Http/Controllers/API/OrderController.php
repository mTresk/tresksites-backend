<?php

namespace App\Http\Controllers\API;

use App\Events\OrderReceivedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function create(OrderRequest $request)
    {
        $formData = $request->validated();

        $path = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
        }

        if ($formData) {
            $order = Order::create([
                ...$formData,
                'attachment' => $path
            ]);

            event(new OrderReceivedEvent($order));
        }

        return response('Сообщение отправлено!', 200)
            ->header('Content-Type', 'text/plain');
    }
}
