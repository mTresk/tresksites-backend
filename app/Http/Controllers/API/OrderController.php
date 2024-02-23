<?php

namespace App\Http\Controllers\API;

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
            Order::create([
                ...$formData,
                'attachment' => $path
            ]);
        }

        return response('Сообщение отправлено!', 200)
            ->header('Content-Type', 'text/plain');
    }
}
