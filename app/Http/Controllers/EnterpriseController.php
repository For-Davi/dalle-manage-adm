<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class EnterpriseController
{
    public function index()
    {
        return Inertia::render('Enterprises');
    }
}
