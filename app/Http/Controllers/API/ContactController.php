<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ContactResource;
use App\Models\Contact;

final class ContactController
{
    public function index()
    {
        return ContactResource::make(Contact::first());
    }
}
