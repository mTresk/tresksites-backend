<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Actions\Contact\GetContacts;
use App\Http\Resources\ContactResource;

final class ContactController
{
    public function index(GetContacts $getContacts): ContactResource
    {
        return new ContactResource(resource: $getContacts->handle());
    }
}
