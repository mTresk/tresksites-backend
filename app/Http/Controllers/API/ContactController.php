<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\ContactResource;
use App\Models\Contact;

final class ContactController
{
    public function index()
    {
        return new ContactResource(resource: Contact::first());
    }
}
