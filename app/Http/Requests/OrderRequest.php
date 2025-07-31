<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:55'],
            'phone' => ['required', 'string'],
            'email' => ['string', 'email', 'nullable'],
            'message' => ['string', 'nullable'],
            'attachment' => ['file', 'nullable', 'max:1024', 'sometimes'],
        ];
    }
}
