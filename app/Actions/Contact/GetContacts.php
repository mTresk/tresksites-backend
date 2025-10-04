<?php

declare(strict_types=1);

namespace App\Actions\Contact;

use App\Models\Contact;

final class GetContacts
{
    public function handle(): Contact
    {
        return Contact::query()->first();
    }
}
