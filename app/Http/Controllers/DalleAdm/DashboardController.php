<?php

namespace App\Http\Controllers\DalleAdm;

use Inertia\Inertia;

class DashboardController
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
