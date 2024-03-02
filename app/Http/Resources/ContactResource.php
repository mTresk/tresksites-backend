<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
