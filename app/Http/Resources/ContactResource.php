<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contact
 */
final class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'inn' => $this->inn,
            'email' => $this->email,
            'telegram' => $this->telegram,
            'block' => $this->block,
            'brief' => $this->brief,
        ];
    }
}
