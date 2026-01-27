<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class RegistrationController
{
    public function show()
    {
        return Inertia::render('Registration');
    }
}
