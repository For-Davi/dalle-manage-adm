<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Exception;
use App\Models\Category;
use Inertia\Inertia;
use Log;

class ClientController
{

    public function index()
    {   
        return Inertia::render('Clients');
    }
}