<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ClientController
{
    public function index()
    {
        return Inertia::render('Clients');
    }
}
