<?php

namespace App\Http\Controllers\DalleAdm;

use Inertia\Inertia;

class ClientController
{
    public function index()
    {
        return Inertia::render('Clients');
    }
}
