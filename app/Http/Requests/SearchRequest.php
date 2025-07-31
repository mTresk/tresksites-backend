<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'keywords' => [
                'string',
                'required',
            ],
        ];
    }
}
